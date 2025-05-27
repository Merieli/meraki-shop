import type { route as routeFn } from 'ziggy-js';
import { User } from '.';

declare global {
    const route: typeof routeFn;
}

type PropsLaravel = {
    props: {
        auth: {
            user: User | null
        }
    }
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $page: PropsLaravel;
    }
}