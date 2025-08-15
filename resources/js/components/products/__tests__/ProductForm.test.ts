import { mount } from '@vue/test-utils';
import { describe, expect, test, vi } from 'vitest';
import { nextTick } from 'vue';
import ProductForm from '../ProductForm.vue';
import { useProductForm } from '../useProductForm';

vi.mock('../useProductForm', () => ({
    useProductForm: vi.fn(() => ({
        formData: {
            name: '',
            description: '',
            price: 0,
            stock: 0,
        },
        error: null,
        success: null,
        veeProductSchema: {},
        submitProduct: vi.fn(),
    })),
}));

describe('ProductForm Component', () => {
    test('Given a new product form, when rendered, then all sections should be displayed', () => {
        const wrapper = mount(ProductForm);

        const sections = wrapper.findAll('h3');
        expect(sections.length).toBe(3);
        expect(sections[0].text()).toBe('Basic Information');
        expect(sections[1].text()).toBe('Pricing & Inventory');
        expect(sections[2].text()).toBe('Media & Rating');
    });

    test('Given a form submission, when an error occurs, then an error message should be displayed', async () => {
        const mockUseProductForm = useProductForm as unknown as ReturnType<typeof vi.fn>;
        mockUseProductForm.mockReturnValue({
            formData: {},
            error: 'Submission failed',
            success: null,
            veeProductSchema: {},
            submitProduct: vi.fn(),
        });

        const wrapper = mount(ProductForm);
        await nextTick();

        const errorAlert = wrapper.findComponent({ name: 'Alert' });
        expect(errorAlert.exists()).toBe(true);
        expect(errorAlert.text()).toContain('Submission failed');
    });

    test('Given a form submission, when successful, then a success message should be displayed', async () => {
        const mockUseProductForm = useProductForm as unknown as ReturnType<typeof vi.fn>;
        mockUseProductForm.mockReturnValue({
            formData: {},
            error: null,
            success: 'Product created successfully',
            veeProductSchema: {},
            submitProduct: vi.fn(),
        });

        const wrapper = mount(ProductForm);
        await nextTick();

        const successAlert = wrapper.findComponent({ name: 'Alert' });
        expect(successAlert.exists()).toBe(true);
        expect(successAlert.text()).toContain('Product created successfully');
    });

    test('Given a valid form, when submitted, then submitProduct should be called with form data', async () => {
        const mockSubmitProduct = vi.fn();
        const mockUseProductForm = useProductForm as unknown as ReturnType<typeof vi.fn>;
        mockUseProductForm.mockReturnValue({
            formData: {
                name: 'Test Product',
                description: 'Test Description',
                price: 100,
                stock: 10,
            },
            error: null,
            success: null,
            veeProductSchema: {},
            submitProduct: mockSubmitProduct,
        });

        const wrapper = mount(ProductForm);
        await nextTick();

        const form = wrapper.findComponent({ name: 'Form' });
        await form.vm.$emit('submit', {
            name: 'Test Product',
            description: 'Test Description',
            price: 100,
            stock: 10,
        });

        expect(mockSubmitProduct).toHaveBeenCalledWith({
            name: 'Test Product',
            description: 'Test Description',
            price: 100,
            stock: 10,
        });
    });
});
