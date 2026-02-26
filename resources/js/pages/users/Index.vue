<template>
    <Head title="Users" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <h1 v-if="(page.props.user_role as string) === 'lead'">Team</h1>
            <h1 v-else>Users</h1>
        </div>
        <div>
        <div v-for="user in page.props.users">
            {{ user.name }} {{ user.role }}
        </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { usePage, Head, App } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import { computed } from 'vue';
import { dashboard } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import { index } from '@/routes/users';
const page = usePage();
const breadcrumbs = computed<BreadcrumbItem[]>(() => {
    return [
        {
            title: 'Dashboard',
            href: dashboard().url,
        },
        {
            title: (page.props.user_role as string) === 'lead' ? 'Team' : 'Users',
            href: index().url,
        },
    ];
});
</script>

<style scoped></style>
