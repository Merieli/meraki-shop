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

type ProductOptionals = Partial<Pick<ProductBase, 'description' | 'sku' | 'images' | 'stock' | 'cost_price'>>;
type ProductRequired = Omit<ProductBase, keyof ProductOptionals>;
export type ProductForm = ProductOptionals & ProductRequired;

export interface ProductFormErrors {
    formErrors: string[];
    fieldErrors: Record<keyof ProductForm, string[]>;
}

type Nullable<T> = { [K in keyof T]: T[K] | null };

/**
 * Define o formato exato dos dados enviados para a API
 */
export type ProductApiData = Required<Nullable<ProductOptionals>> & ProductRequired;

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
