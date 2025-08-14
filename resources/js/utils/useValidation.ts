import type { EnumSchema, FieldSchema, FormErrors, NumberSchema, StringSchema } from './useValidation.type';

export const createSchema = () => {
    const string = () => {
        const schema: StringSchema = {
            type: 'string',
            validate: (value: any) => {
                if (schema.minLength !== undefined && (!value || value.length < schema.minLength)) {
                    return { valid: false, message: schema.message };
                }
                if (schema.maxLength !== undefined && value && value.length > schema.maxLength) {
                    return { valid: false, message: schema.message };
                }
                if (schema.pattern && !schema.pattern.test(value)) {
                    return { valid: false, message: schema.message };
                }
                return { valid: true };
            },
        };

        return {
            min: (length: number, options: { message: string }) => {
                schema.minLength = length;
                schema.message = options.message;
                return {
                    max: (length: number, options: { message: string }) => {
                        schema.maxLength = length;
                        schema.message = options.message;
                        return schema;
                    },
                    regex: (pattern: RegExp, options: { message: string }) => {
                        schema.pattern = pattern;
                        schema.message = options.message;
                        return schema;
                    },
                    __schema: schema,
                };
            },
            max: (length: number, options: { message: string }) => {
                schema.maxLength = length;
                schema.message = options.message;
                return {
                    min: (length: number, options: { message: string }) => {
                        schema.minLength = length;
                        schema.message = options.message;
                        return schema;
                    },
                    regex: (pattern: RegExp, options: { message: string }) => {
                        schema.pattern = pattern;
                        schema.message = options.message;
                        return schema;
                    },
                    __schema: schema,
                };
            },
            regex: (pattern: RegExp, options: { message: string }) => {
                schema.pattern = pattern;
                schema.message = options.message;
                return {
                    min: (length: number, options: { message: string }) => {
                        schema.minLength = length;
                        schema.message = options.message;
                        return schema;
                    },
                    max: (length: number, options: { message: string }) => {
                        schema.maxLength = length;
                        schema.message = options.message;
                        return schema;
                    },
                    __schema: schema,
                };
            },
            __schema: schema,
        };
    };

    // Number schema
    const number = () => {
        const schema: NumberSchema = {
            type: 'number',
            validate: (value: any) => {
                const numValue = Number(value);
                if (schema.min !== undefined && numValue < schema.min) {
                    return { valid: false, message: schema.message };
                }
                if (schema.max !== undefined && numValue > schema.max) {
                    return { valid: false, message: schema.message };
                }
                return { valid: true };
            },
        };

        return {
            min: (value: number, options: { message: string }) => {
                schema.min = value;
                schema.message = options.message;
                return {
                    max: (value: number, options: { message: string }) => {
                        schema.max = value;
                        schema.message = options.message;
                        return schema;
                    },
                    __schema: schema,
                };
            },
            max: (value: number, options: { message: string }) => {
                schema.max = value;
                schema.message = options.message;
                return {
                    min: (value: number, options: { message: string }) => {
                        schema.min = value;
                        schema.message = options.message;
                        return schema;
                    },
                    __schema: schema,
                };
            },
            __schema: schema,
        };
    };

    const enumSchema = (values: string[]): EnumSchema => {
        return {
            type: 'enum',
            values,
            validate: (value: any) => {
                if (!values.includes(value)) {
                    return { valid: false, message: 'Invalid value' };
                }
                return { valid: true };
            },
        };
    };

    const object = (schemaFields: Record<string, any>) => {
        const extractedSchema: Record<string, FieldSchema> = {};

        Object.entries(schemaFields).forEach(([key, value]) => {
            if (value && typeof value === 'object' && value.__schema) {
                extractedSchema[key] = value.__schema;
            } else if (value && typeof value === 'object' && value.type === 'enum') {
                extractedSchema[key] = value;
            }
        });

        return {
            schema: extractedSchema,
        };
    };

    return {
        string,
        number,
        enum: enumSchema,
        object,
    };
};

export const z = createSchema();

export const useValidation = <T extends Record<string, any>>(schema: { schema: Record<string, FieldSchema> }, initialErrors: FormErrors = {}) => {
    const errors = ref<FormErrors>(initialErrors);

    const validateField = (field: string, value: any): boolean => {
        const fieldSchema = schema.schema[field];
        if (!fieldSchema) return true;

        const result = fieldSchema.validate(value);
        if (!result.valid && result.message) {
            errors.value[field] = result.message as unknown as object;
            return false;
        }

        delete errors.value[field];
        return true;
    };

    const validateAll = (values: T): boolean => {
        let isValid = true;
        errors.value = {};

        Object.keys(schema.schema).forEach((field) => {
            if (!validateField(field, values[field as keyof T])) {
                isValid = false;
            }
        });

        return isValid;
    };

    return {
        errors,
        validateField,
        validateAll,
    };
};

import { ref } from 'vue';
