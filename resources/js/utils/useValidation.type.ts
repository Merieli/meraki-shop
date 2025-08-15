export type ValidationMessage = string;

export interface SchemaValidation {
    validate: (value: any) => { valid: boolean; message?: ValidationMessage };
}

export interface StringSchema extends SchemaValidation {
    type: 'string';
    minLength?: number;
    maxLength?: number;
    pattern?: RegExp;
    message?: ValidationMessage;
}

export interface NumberSchema extends SchemaValidation {
    type: 'number';
    min?: number;
    max?: number;
    message?: ValidationMessage;
}

export interface EnumSchema extends SchemaValidation {
    type: 'enum';
    values: string[];
    message?: ValidationMessage;
}

export type FieldSchema = StringSchema | NumberSchema | EnumSchema;

export interface FormErrors {
    [key: string]: object;
}
