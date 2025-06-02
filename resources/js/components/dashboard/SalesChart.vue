<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

interface DataPoint {
    date: string;
    sales: number;
}

interface Props {
    data: DataPoint[];
    title: string;
}

const props = defineProps<Props>();
const chartContainer = ref<HTMLDivElement | null>(null);

const maxSales = computed(() => {
    return Math.max(...props.data.map((point) => point.sales));
});

const formattedDates = computed(() => {
    return props.data.map((point) => {
        const date = new Date(point.date);
        return date.toLocaleDateString('en-US', { weekday: 'short' });
    });
});

onMounted(() => {
    // This is a simplified chart implementation
    // In a real application, you would use a chart library like Chart.js
    drawChart();
});

const drawChart = () => {
    if (!chartContainer.value) return;

    const container = chartContainer.value;
    container.innerHTML = '';

    const chartHeight = 150;
    const chartWidth = container.clientWidth;
    const barWidth = (chartWidth / props.data.length) * 0.7;
    const barSpacing = (chartWidth / props.data.length) * 0.3;

    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('width', '100%');
    svg.setAttribute('height', `${chartHeight}px`);
    svg.setAttribute('viewBox', `0 0 ${chartWidth} ${chartHeight}`);
    svg.setAttribute('class', 'sales-chart');

    // Draw bars
    props.data.forEach((point, index) => {
        const barHeight = (point.sales / maxSales.value) * (chartHeight - 30);
        const x = index * (barWidth + barSpacing) + barSpacing / 2;
        const y = chartHeight - barHeight - 20;

        // Create a group for the bar elements
        const barGroup = document.createElementNS('http://www.w3.org/2000/svg', 'g');

        // Background/highlight for the bar (more visible in dark mode)
        const barHighlight = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        barHighlight.setAttribute('x', (x - 1).toString());
        barHighlight.setAttribute('y', (y - 1).toString());
        barHighlight.setAttribute('width', (barWidth + 2).toString());
        barHighlight.setAttribute('height', (barHeight + 2).toString());
        barHighlight.setAttribute('rx', '4');
        barHighlight.setAttribute('class', 'chart-bar-highlight');

        // Main bar
        const bar = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        bar.setAttribute('x', x.toString());
        bar.setAttribute('y', y.toString());
        bar.setAttribute('width', barWidth.toString());
        bar.setAttribute('height', barHeight.toString());
        bar.setAttribute('rx', '3');
        bar.setAttribute('class', 'chart-bar');

        // Value display on top of the bar
        const valueText = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        valueText.setAttribute('x', (x + barWidth / 2).toString());
        valueText.setAttribute('y', (y - 5).toString());
        valueText.setAttribute('text-anchor', 'middle');
        valueText.setAttribute('font-size', '10');
        valueText.setAttribute('class', 'chart-value');
        valueText.textContent = `$${Math.round(point.sales / 100000)}k`;

        // Text label (day)
        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', (x + barWidth / 2).toString());
        text.setAttribute('y', (chartHeight - 5).toString());
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('font-size', '12');
        text.setAttribute('fill', 'hsl(var(--muted-foreground))');
        text.textContent = formattedDates.value[index];

        // Add elements to SVG
        barGroup.appendChild(barHighlight);
        barGroup.appendChild(bar);
        barGroup.appendChild(valueText);
        svg.appendChild(barGroup);
        svg.appendChild(text);
    });

    container.appendChild(svg);
};
</script>

<template>
    <div class="bg-card rounded-xl border p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-medium">{{ title }}</h3>
        <div ref="chartContainer" class="h-[180px] w-full"></div>
    </div>
</template>

<style>
.chart-bar {
    fill: #3b82f6; /* Blue-500 */
    opacity: 0.85;
}

.chart-bar-highlight {
    fill: transparent;
    stroke: #3b82f6; /* Blue-500 */
    stroke-width: 2;
}

.chart-value {
    fill: hsl(var(--foreground));
    opacity: 0.9;
    font-weight: 500;
}

/* Adjust bar appearance in dark mode */
:root.dark .chart-bar {
    fill: #60a5fa; /* Blue-400 - mais claro para o tema escuro */
    filter: brightness(1.2);
}

:root.dark .chart-bar-highlight {
    stroke: #93c5fd; /* Blue-300 - ainda mais claro para o contorno */
    stroke-width: 2;
    filter: brightness(1.5);
}

:root.dark .chart-value {
    fill: white;
    opacity: 1;
}

:root.dark .sales-chart {
    filter: drop-shadow(0 0 3px rgba(96, 165, 250, 0.3));
}
</style>
