import { type PartialProductData, type ProductApiData, type ProductFormData } from '@/types/product';
import { z } from '@/utils/formValidation';
import { toCents } from '@/utils/money';

export const defaultFormData: ProductFormData = {
    name: '',
    price: 0,
    cost_price: 0,
    stock: 0,
    thumbnail: 'https://placeholder.com/300x200',
    images: '',
    short_description: '',
    description: '',
    rating: 1,
    sku: '',
};

export const productSchema = z.object({
    name: z.string().min(4, { message: 'Nome deve ter pelo menos 4 caracteres.' }).max(150, { message: 'Nome não pode exceder 150 caracteres.' }),
    price: z.number().min(0, { message: 'Preço não pode ser negativo.' }),
    cost_price: z.number().min(0, { message: 'Preço de custo não pode ser negativo.' }),
    stock: z.number().min(0, { message: 'Estoque não pode ser negativo.' }),
    thumbnail: z.string().min(5, { message: 'URL da imagem é obrigatória e deve ter pelo menos 5 caracteres.' }),
    images: z.string(),
    short_description: z
        .string()
        .min(10, { message: 'Descrição curta deve ter pelo menos 10 caracteres.' })
        .max(255, { message: 'Descrição curta não pode exceder 255 caracteres.' }),
    description: z.string(),
    rating: z.number().min(1, { message: 'Avaliação deve ser pelo menos 1.' }).max(5, { message: 'Avaliação não pode exceder 5.' }),
    sku: z.string().max(50, { message: 'SKU não pode exceder 50 caracteres.' }),
});

/**
 * Converts form data values to the format expected by the API
 */
export const convertToApiFormat = (data: ProductFormData): ProductApiData => {
    return {
        name: formatName(data),
        price: formatPrice(data),
        cost_price: formatCostPrice(data),
        stock: formatStock(data),
        thumbnail: formatThumbnail(data),
        images: formatImages(data),
        short_description: formatShortDescription(data),
        description: formatDescription(data),
        rating: formatRating(data),
        sku: formatSku(data),
    };
};

/**
 * Filters out empty fields from API data to send only filled values
 */
export const filterFilledFields = (data: ProductApiData): Partial<ProductApiData> => {
    const filteredData: Partial<ProductApiData> = {};

    // Always include required fields
    if (data.name && data.name.trim()) filteredData.name = data.name;
    if (data.price !== undefined && data.price >= 0) filteredData.price = data.price;
    if (data.thumbnail && data.thumbnail.trim()) filteredData.thumbnail = data.thumbnail;
    if (data.short_description && data.short_description.trim()) filteredData.short_description = data.short_description;
    if (data.rating !== undefined && data.rating >= 1) filteredData.rating = data.rating;

    // Optional fields - only include if they have value
    if (data.cost_price !== null && data.cost_price !== undefined && data.cost_price >= 0) {
        filteredData.cost_price = data.cost_price;
    }
    if (data.stock !== null && data.stock !== undefined && data.stock >= 0) {
        filteredData.stock = data.stock;
    }
    if (data.images && data.images.trim()) {
        filteredData.images = data.images;
    }
    if (data.description && data.description.trim()) {
        filteredData.description = data.description;
    }
    if (data.sku && data.sku.trim()) {
        filteredData.sku = data.sku;
    }

    return filteredData;
};

const formatName = (data: ProductFormData): string => {
    return data.name.trim();
};

const formatPrice = (data: ProductFormData): number => {
    return toCents(data.price);
};

const formatCostPrice = (data: ProductFormData): number | null => {
    if (!data.cost_price) return null;

    return toCents(data.cost_price);
};

const formatStock = (data: ProductFormData): number | null => {
    if (!data.stock) return null;

    return Math.round(data.stock);
};

const formatThumbnail = (data: ProductFormData): string => {
    return data.thumbnail.trim();
};

const formatImages = (data: ProductFormData): string | null => {
    if (!data.images) return null;

    return data.images.trim();
};

const formatShortDescription = (data: ProductFormData): string => {
    return data.short_description.trim();
};

const formatDescription = (data: ProductFormData): string | null => {
    if (!data.description) {
        return null;
    }
    return data.description.trim();
};

const formatRating = (data: ProductFormData): number => {
    const rating = Math.round(data.rating || 1);
    if (rating < 1) {
        return 1;
    }
    if (rating > 5) {
        return 5;
    }
    return rating;
};

const formatSku = (data: ProductFormData): string | null => {
    if (!data.sku) {
        return null;
    }
    return data.sku.trim();
};
