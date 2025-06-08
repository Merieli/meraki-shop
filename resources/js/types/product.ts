/**
 * Define os campos base de um produto com todos os campos requeridos
 */
export interface ProductBase {
    name: string;
    price: number;
    cost_price: number;
    stock: number;
    thumbnail: string;
    images: string;
    short_description: string;
    description: string;
    rating: number;
    sku: string;
}

/**
 * Campos que são opcionais na API (podem ser null)
 */
export type OptionalApiFields = 'cost_price' | 'stock' | 'images' | 'description' | 'sku';

/**
 * Define o formato exato dos dados enviados para a API
 * Alguns campos são opcionais (podem ser null) e outros são obrigatórios
 */
export type ProductApiData = {
    [K in keyof ProductBase]: K extends OptionalApiFields ? ProductBase[K] | null : ProductBase[K];
};

/**
 * Tipo usado para o formulário de criação/edição de produto
 * Todos os campos são obrigatórios no formulário para simplificar a validação
 */
export type ProductFormData = ProductBase;

/**
 * Tipo para inicialização parcial de dados do formulário
 */
export type PartialProductData = Partial<ProductFormData>;

/**
 * Tipo para a resposta da API (inclui campos adicionais como id, created_at, etc.)
 */
export interface ProductResponse extends ProductApiData {
    id: number;
    created_at: string;
    updated_at: string;
}

/**
 * Interface para o produto usado no frontend
 */
export interface Product {
    id: number;
    name: string;
    price: number;
    thumbnail: string;
    image?: string;
    category?: string;
    shortDescription: string;
    rating: number;
    inStock: boolean;
}

/**
 * Interface para o produto recebido da API
 */
export interface ApiProduct {
    id: number;
    name: string;
    price: string | number;
    short_description: string;
    thumbnail: string;
    rating: number;
    images?: string[];
    description?: string;
    sku?: string;
    stock?: number;
}
