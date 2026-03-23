<template>
    <div>

    </div>
</template>

<script setup lang="ts">
import type { Course } from '@/types';
import type { PageProps } from '@inertiajs/core';
import { usePage } from '@inertiajs/vue3';
import {
    ChartColumnBig,
    SquareChartGantt,
    TriangleAlert,
    Users,
} from 'lucide-vue-next';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const isModalOpened = ref(false);
const selectedCourse = ref<any>(null);
const dashboardData = ref<any>(null);

const getAdminDashboardData = async () => {
    try {
        const response = await axios.get('/api/admin-dashboard');
        dashboardData.value = response.data;
        console.log('Dashboard data:', response.data);
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};
onMounted(() => {
    // Fetch data for the dashboard
    getAdminDashboardData();
});
          
  

</script>

<style scoped>

</style>