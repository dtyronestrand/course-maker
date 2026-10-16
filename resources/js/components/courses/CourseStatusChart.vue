<template>
    <Bar id="course-status" :data="chartData" :options="chartOptions" />
</template>

<script setup lang="ts">
import type { ChartData } from 'chart.js';
import {
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Legend,
    LinearScale,
    Title,
    Tooltip,
} from 'chart.js';
import { computed } from 'vue';
import { Bar } from 'vue-chartjs';
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
);

interface Props {
    courseStatusCounts: Record<string, number>;
}

const props = defineProps<Props>();
const chartData = computed<ChartData<'bar'>>(() => {
    return {
        labels: Object.keys(props.courseStatusCounts).map((key) =>
            key.toUpperCase(),
        ),
        color: 'white',
        datasets: [
            {
                label: 'Number of Courses',
                backgroundColor: ['hsl(46.957, 100%, 59.412%)', 'hsl(24, 5.747%, 82.941%)', 'hsl(60, 9.302%, 83.137%)'],
                data: Object.values(props.courseStatusCounts),
            },
        ],
    };
});

const chartOptions = {
    plugins: {
        legend: {
            display: false,
        },
    },
    responsive: true,
    scales: {
        y: {
            ticks: {
                color: '#191c1e',
            },
        },
        x: {
            ticks: {
                color: '#191c1e',
            },
        },
    },
};
</script>

<style scoped></style>
