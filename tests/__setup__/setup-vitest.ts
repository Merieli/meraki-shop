import { config } from '@vue/test-utils';
import { vi } from 'vitest';

/**
 * Frontend Test Setup
 *
 * This file configures global mocks and setup for Vue frontend unit tests
 * using Vitest and Vue Test Utils.
 */

// Global Vue Test Utils configuration
config.global.mocks = {
    // Mock translation function for internationalization tests
    $t: (key: string) => key,
};

// Mock Vue-specific global properties and composables
config.global.provide = {
    // Add any global provides here if needed
};

// Mocking external libraries used in frontend components
vi.mock('vee-validate', async () => {
    const actual = await vi.importActual('vee-validate');
    return {
        ...actual,
        // Mock form validation composables
        useField: () => ({
            value: '',
            errorMessage: '',
            handleBlur: vi.fn(),
            handleChange: vi.fn(),
        }),
        useForm: () => ({
            handleSubmit: vi.fn(),
            meta: { valid: true },
            errors: {},
        }),
    };
});

// Mocking other common frontend libraries can be added here
// Example:
// vi.mock('@vueuse/core', () => ({
//     useStorage: vi.fn(),
// }));

// Global error handler to prevent unhandled errors from breaking tests
window.addEventListener('error', (event) => {
    // Prevent default error handling to keep test output clean
    event.preventDefault();
});
