import { type ProductApiData, type ProductForm } from '@/types/product';
import { apiService } from '@/utils/api';
import { toCents } from '@/utils/money';
import { toTypedSchema } from '@vee-validate/zod';
import { ref } from 'vue';
import * as z from 'zod';

export function useProductForm() {
    const initialData: Partial<ProductForm> = {
        rating: 5,
    };

    const validateStringRequired = {
        error: (issue: { input: unknown }) => (issue.input === undefined ? 'Required' : 'Not a string'),
    };
    const validateNumberRequired = {
        error: (issue: { input: unknown }) => (!issue.input === undefined ? 'Required' : 'Required'),
    };

    const productSchema = z.object({
        name: z
            .string(validateStringRequired)
            .min(4, { message: 'Name must be at least 4 characters long.' })
            .max(150, { message: 'Name cannot exceed 150 characters.' })
            .nonempty({ message: 'Name is required.' }),
        short_description: z
            .string(validateStringRequired)
            .min(10, { message: 'Short description must be at least 10 characters long.' })
            .max(255, { message: 'Descrição curta não pode exceder 255 caracteres.' }),
        description: z.optional(z.string()),
        price: z.number(validateNumberRequired).min(0.01, { message: 'Price cannot be less than 0.01.' }),
        cost_price: z.optional(z.number().min(0, { message: 'Cost price cannot be negative.' })),
        stock: z.optional(z.number().min(0, { message: 'Stock cannot be negative.' })),
        thumbnail: z.string(validateStringRequired).min(5, { message: 'Image URL is mandatory and must have at least 5 characters.' }),
        images: z.optional(z.string()),
        rating: z.number(validateNumberRequired).min(1, { message: 'Rating must be at least 1.' }).max(5, { message: 'Rating cannot exceed 5.' }),
        sku: z.optional(z.string().max(50, { message: 'SKU cannot exceed 50 characters' })),
    });
    const veeProductSchema = toTypedSchema(productSchema);

    const formData = ref<Partial<ProductForm>>(initialData);

    const isSubmitting = ref(false);
    const error = ref<string | null>(null);
    const success = ref<string | null>(null);
    const isValid = ref(false);

    const resetForm = () => {
        formData.value = initialData;
        error.value = null;
        success.value = null;
    };

    const submitProduct = async (values: ProductForm): Promise<any> => {
        error.value = null;
        success.value = null;

        const validSchema = productSchema.safeParse(values);
        if (!validSchema.success) {
            console.error('Erro de validação:', validSchema.error);
            error.value = 'Por favor, corrija os erros no formulário antes de continuar.';
            return false;
        }
        isSubmitting.value = true;

        try {
            const apiData = convertToApiFormat(validSchema.data);

            const response = await apiService.create('products', apiData, true);

            success.value = 'Produto criado com sucesso!';
            return response;
        } catch (err: any) {
            console.error('Erro ao criar produto:', err);

            if (err?.response?.status === 422) {
                error.value = 'Dados inválidos. Verifique os campos preenchidos.';
            } else if (err?.response?.status === 401) {
                error.value = 'Você precisa estar logado para criar produtos.';
            } else if (err?.response?.status === 403) {
                error.value = 'Você não tem permissão para criar produtos.';
            } else {
                error.value = 'Erro interno do servidor. Tente novamente mais tarde.';
            }

            return false;
        } finally {
            isSubmitting.value = false;
        }
    };

    const formatter: Record<keyof ProductForm, (data: ProductForm) => any> = {
        name: (data: ProductForm): string => data.name.trim(),
        price: (data: ProductForm): number => toCents(data.price),
        cost_price: (data: ProductForm): number | undefined => (data.cost_price ? toCents(data.cost_price) : data.cost_price),
        stock: (data: ProductForm): number | undefined => (data.stock ? Math.round(data.stock!) : data.stock),
        thumbnail: (data: ProductForm): string => data.thumbnail.trim(),
        images: (data: ProductForm): string | undefined => data.images,
        short_description: (data: ProductForm): string => data.short_description.trim(),
        description: (data: ProductForm): string | undefined => data.description,
        rating: (data: ProductForm): number => data.rating,
        sku: (data: ProductForm): string => data.sku!.trim(),
    };

    // Converts form data values to the format expected by the API
    const convertToApiFormat = (data: ProductForm): ProductApiData => {
        const currentObject: Record<string, unknown> = {} as ProductApiData;
        const keys = Object.keys(data) as (keyof ProductForm)[];
        keys.forEach((key) => {
            if (data[key] === undefined) {
                currentObject[key] = null;
                return;
            }
            currentObject[key] = formatter[key](data);
        });

        return currentObject as ProductApiData;
    };

    return {
        formData,
        isSubmitting,
        error,
        success,
        isValid,
        veeProductSchema,
        resetForm,
        submitProduct,
    };
}
