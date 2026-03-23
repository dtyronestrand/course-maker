<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { defineAsyncComponent } from 'vue';
import { dashboard } from '@/routes';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
const page = usePage();
const adminDashboard = defineAsyncComponent(() => import('@/components/AdminDashboard.vue'));
const userDashboard = defineAsyncComponent(() => import('@/components/UserDashboard.vue'));
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <adminDashboard v-if="page.props.user_role === 'admin'" />
        <userDashboard v-else />
    </AppLayout>
</template>
