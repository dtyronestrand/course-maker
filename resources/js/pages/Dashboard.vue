<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Course, BreadcrumbItem } from '@/types';
import { defineAsyncComponent } from 'vue';
import { dashboard } from '@/routes';
import type { PageProps } from '@inertiajs/core';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
interface DashboardPageProps extends PageProps {
    
    courses: Course[];
}

const page = usePage<DashboardPageProps>();
const adminDashboard = defineAsyncComponent(() => import('@/components/AdminDashboard.vue'));
const userDashboard = defineAsyncComponent(() => import('@/components/UserDashboard.vue'));
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <adminDashboard v-if="page.props.user_role === 'admin'" :courses="page.props.courses" />
        <userDashboard v-else />
    </AppLayout>
</template>
