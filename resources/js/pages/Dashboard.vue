<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Course, BreadcrumbItem } from '@/types';
import { computed, defineAsyncComponent } from 'vue';
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
    user_role: string | null;
    is_admin?: boolean;
    is_lead?: boolean;
}

const page = usePage<DashboardPageProps>();
const AdminDashboard = defineAsyncComponent(
    () => import('@/components/AdminDashboard.vue'),
);
const UserDashboard = defineAsyncComponent(
    () => import('@/components/UserDashboard.vue'),
);
const LeadDashboard = defineAsyncComponent(
    () => import('@/components/LeadDashboard.vue'),
);
const isAdmin = computed(
    () => page.props.is_admin ?? page.props.user_role === 'admin',
);
const isLead = computed(() => page.props.user_role === 'lead');
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <AdminDashboard :courses="page.props.courses" v-if="isAdmin" />
        <LeadDashboard v-else-if="isLead" :courses="page.props.courses"/>
        <UserDashboard v-else />
    </AppLayout>
</template>
