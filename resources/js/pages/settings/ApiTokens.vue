<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'API Tokens',
        href: '/settings/api-tokens',
    },
];

const page = usePage<SharedData>();
const loading = ref(false);
const success = ref(false);
const error = ref('');
const newToken = ref('');

const form = useForm({
    token_name: '',
});

const createToken = async () => {
    loading.value = true;
    error.value = '';
    newToken.value = '';

    try {
        const response = await axios.post('/api/tokens/create', {
            token_name: form.token_name,
        });

        newToken.value = response.data.token;
        success.value = true;
        form.reset();
    } catch (err) {
        error.value = 'Não foi possível criar o token. Tente novamente.';
    } finally {
        loading.value = false;
    }
};

const copyToken = () => {
    navigator.clipboard.writeText(newToken.value);
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="API Tokens" />

        <SettingsLayout>
            <div class="flex flex-col space-y-8">
                <HeadingSmall title="API Tokens" description="Crie tokens para acessar nossa API através de aplicações externas" />

                <Alert v-if="newToken" class="mb-6 border-green-200 bg-green-50">
                    <AlertTitle>Token criado com sucesso!</AlertTitle>
                    <AlertDescription>
                        <div class="mt-2">
                            <p class="mb-2 text-sm text-gray-700">Copie seu token agora. Você não poderá vê-lo novamente:</p>
                            <div class="flex">
                                <Input readonly :value="newToken" class="flex-1 font-mono text-xs" />
                                <Button type="button" @click="copyToken" class="ml-2">Copiar</Button>
                            </div>
                        </div>
                    </AlertDescription>
                </Alert>

                <Alert v-if="error" class="mb-6 border-red-200 bg-red-50">
                    <AlertTitle>Erro</AlertTitle>
                    <AlertDescription>{{ error }}</AlertDescription>
                </Alert>

                <form @submit.prevent="createToken" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="token_name">Nome do Token</Label>
                        <Input id="token_name" v-model="form.token_name" class="mt-1 block w-full" required placeholder="Meu Aplicativo" />
                        <p class="text-sm text-gray-500">Dê um nome para identificar este token (ex: "Aplicativo Mobile", "Integração XYZ")</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button type="submit" :disabled="loading">
                            <span v-if="loading">Criando...</span>
                            <span v-else>Criar Token</span>
                        </Button>
                    </div>
                </form>

                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium">Informações de Uso</h3>
                    <div class="mt-4 space-y-4">
                        <p class="text-sm text-gray-600">Para usar o token na API, inclua-o no cabeçalho de suas requisições:</p>
                        <div class="rounded-md bg-gray-100 p-3">
                            <code class="text-sm"> Authorization: Bearer SEU_TOKEN_AQUI </code>
                        </div>
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
