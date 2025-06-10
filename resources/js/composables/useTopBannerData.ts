import { apiService } from '@/utils/api';
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface Address {
    street: string;
    number: string;
    city: string;
}

interface CreditCard {
    card_last4: string;
}

export function useTopBannerData() {
    const page = usePage<{ auth?: { user: any } }>();
    const isLoggedIn = computed(() => !!page.props.auth?.user);

    const address = ref<Address | null>(null);
    const creditCard = ref<CreditCard | null>(null);

    const fetchTopBannerData = async () => {
        if (!isLoggedIn.value) return;

        const [addressResult, creditCardResult] = await Promise.allSettled([
            apiService.list<Address[]>('address', {}, true),
            apiService.list<CreditCard[]>('credit-card', {}, true),
        ]);

        if (addressResult.status === 'fulfilled' && addressResult.value.length > 0) {
            address.value = addressResult.value[0];
        }

        if (addressResult.status === 'rejected' && addressResult.reason.response?.status !== 404) {
            console.error('Error fetching address:', addressResult.reason);
        }

        if (creditCardResult.status === 'fulfilled' && creditCardResult.value.length > 0) {
            creditCard.value = creditCardResult.value[0];
        }

        if (creditCardResult.status === 'rejected' && creditCardResult.reason.response?.status !== 404) {
            console.error('Error fetching credit card:', creditCardResult.reason);
        }
    };

    return {
        address,
        creditCard,
        fetchTopBannerData,
    };
}
