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
            apiService.list<Address | Address[]>('address', {}, true),
            apiService.list<CreditCard>('credit-card', {}, true),
        ]);

        if (addressResult.status === 'fulfilled') {
            const addressResponse = addressResult.value;
            if (Array.isArray(addressResponse) && addressResponse.length > 0 && addressResponse[0].street) {
                address.value = addressResponse[0];
            } else if (addressResponse && !Array.isArray(addressResponse) && (addressResponse as Address).street) {
                address.value = addressResponse as Address;
            } else {
                address.value = null;
            }
        } else if (addressResult.reason.response?.status !== 404) {
            console.error('Error fetching address:', addressResult.reason);
        }

        if (creditCardResult.status === 'fulfilled') {
            const card = creditCardResult.value;
            if (card && card.card_last4) {
                creditCard.value = card;
            } else {
                creditCard.value = null;
            }
        } else if (creditCardResult.status === 'rejected') {
            if (creditCardResult.reason.response?.status !== 404) {
                console.error('Error fetching credit card:', creditCardResult.reason);
            }
            creditCard.value = null;
        }
    };

    return {
        address,
        creditCard,
        fetchTopBannerData,
    };
}
