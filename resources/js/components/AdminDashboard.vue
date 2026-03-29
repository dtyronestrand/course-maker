<template>
    <div></div>
</template>

<script setup lang="ts">
import axios from 'axios';
import { onMounted, ref } from 'vue';

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

<style scoped></style>
