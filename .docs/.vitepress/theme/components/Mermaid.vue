<script setup lang="ts">
import mermaid from 'mermaid';
import { onMounted, ref, watch } from 'vue';

interface Props {
    code: string;
}

const props = defineProps<Props>();

const diagram = ref<HTMLElement | null>(null);
const error = ref<string | null>(null);

const initMermaid = () => {
    try {
        mermaid.initialize({
            startOnLoad: false,
            securityLevel: 'loose',
            theme: 'default',
            fontFamily: 'inherit',
            flowchart: {
                useMaxWidth: false,
                htmlLabels: true,
            },
        });
    } catch (e: unknown) {
        const errorMessage = e instanceof Error ? e.message : 'Erro desconhecido';
        error.value = `Erro na inicialização: ${errorMessage}`;
    }
};

const renderDiagram = async () => {
    if (!diagram.value) return;

    try {
        const decodedCode = decodeURIComponent(props.code);

        const firstLine = decodedCode.split('\n')[0].trim();
        const hasDiagramType = /^(flowchart|graph|sequenceDiagram|gantt|erDiagram|pie|journey|classDiagram|stateDiagram|gitGraph)\b/i.test(firstLine);

        const finalCode = hasDiagramType ? decodedCode : `flowchart TD\n${decodedCode}`;

        await mermaid.parse(finalCode);

        diagram.value.innerHTML = finalCode;
        await mermaid.run(undefined, diagram.value);
        error.value = null;
    } catch (e: unknown) {
        const errorMessage = e instanceof Error ? e.message : 'Erro desconhecido';
        error.value = `Erro no diagrama: ${errorMessage}`;
        if (diagram.value) {
            diagram.value.innerHTML = '';
        }
        console.error('Mermaid error details:', e);
    }
};

onMounted(() => {
    initMermaid();
    renderDiagram();
});

watch(() => props.code, renderDiagram);
</script>

<template>
    <div class="mermaid-container">
        <div v-if="error" class="error">
            {{ error }}
            <pre>{{ decodeURIComponent(props.code) }}</pre>
        </div>
        <div ref="diagram" class="mermaid"></div>
    </div>
</template>

<style>
.mermaid-container {
    margin: 1.5rem 0;
    border: 1px solid var(--vp-c-divider);
    border-radius: 8px;
    padding: 1rem;
    background: var(--vp-c-bg-soft);
}

.mermaid {
    text-align: center;
    overflow: auto;
}

.error {
    color: #ff3333;
    font-family: monospace;
    margin-bottom: 1rem;
    white-space: pre-wrap;
}
</style>
