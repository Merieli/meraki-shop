<script setup>
import mermaid from 'mermaid';
import { onMounted, ref, watch } from 'vue';

const props = defineProps({
    code: { type: String, required: true },
});

const diagram = ref(null);
const error = ref(null);

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
    } catch (e) {
        error.value = `Erro na inicialização: ${e.message}`;
    }
};

const renderDiagram = async () => {
    if (!diagram.value) return;

    try {
        // Decodifica o conteúdo URL encoded
        const decodedCode = decodeURIComponent(props.code);

        // Verifica se há texto antes do tipo de diagrama
        const firstLine = decodedCode.split('\n')[0].trim();
        const hasDiagramType = /^(flowchart|graph|sequenceDiagram|gantt|erDiagram|pie|journey|classDiagram|stateDiagram|gitGraph)\b/i.test(firstLine);

        // Adiciona o tipo de diagrama se não estiver presente
        const finalCode = hasDiagramType ? decodedCode : `flowchart TD\n${decodedCode}`;

        // Valida a sintaxe
        await mermaid.parse(finalCode);

        // Renderiza o diagrama
        diagram.value.innerHTML = finalCode;
        await mermaid.init(undefined, diagram.value);
        error.value = null;
    } catch (e) {
        error.value = `Erro no diagrama: ${e.message}`;
        diagram.value.innerHTML = '';
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
            <pre>{{ decodeURIComponent(code) }}</pre>
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
