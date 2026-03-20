<template>
    <Head title="Users" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-row justify-between pt-4 text-3xl">
            <h1 v-if="(page.props.user_role as string) === 'lead'">Team</h1>
            <h1 v-else>Users</h1>
            <div v-if="(page.props.user_role as string) === 'admin'">
                <Button @click="showModal = true">+ User</Button>
            </div>
        </div>
        <div class="rounded mx-8 mt-4 glass">
            <UserTable
                :teams="page.props.teams as Team[]"
                :users="page.props.users as User[]"
            />
        </div>
        <Modal
            :visible="showModal"
            title="Create User"
            @close="showModal = false"
        >
            <template #header>
                <h2>Create New User</h2>
            </template>
            <template #body>
                <form @submit.prevent="addUser">
                    <label for="name" class="mb-2 block">Name</label>
                    <input
                        type="text"
                        v-model="form.name"
                        class="mb-4 w-full rounded border border-gray-300 p-2"
                        required
                    />
                    <label for="email" class="mb-2 block">Email</label>
                    <input
                        type="email"
                        v-model="form.email"
                        class="mb-4 w-full rounded border border-gray-300 p-2"
                        required
                    />
                    <label for="role" class="mb-2 block">Role</label>
                    <select
                        v-model="form.role"
                        class="mb-4 w-full rounded border border-gray-300 p-2"
                        required
                    >
                        <option value="id">ID</option>
                        <option value="lead">Lead</option>
                        <option value="sme">Sme</option>
                    </select>
                    <Button type="submit" class="glass">Create</Button>
                </form>
            </template>
        </Modal>
    </AppLayout>
</template>

<script setup lang="ts">
import { usePage, Head, useForm } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import type { BreadcrumbItem } from '@/types';
import { computed, ref } from 'vue';
import { dashboard } from '@/routes';
import type { User } from '@/types/auth';
import type { Team } from '@/types';
import UserTable from '@/components/UserTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { index } from '@/routes/users';
import Modal from '@/components/Modal.vue';
const page = usePage();
const showModal = ref(false);
const form = useForm({
    name: '',
    email: '',
    password: '',
    role: 'id',
});
const breadcrumbs = computed<BreadcrumbItem[]>(() => {
    return [
        {
            title: 'Dashboard',
            href: dashboard().url,
        },
        {
            title:
                (page.props.user_role as string) === 'lead' ? 'Team' : 'Users',
            href: index().url,
        },
    ];
});
const addUser = () => {
    form.post('/users', {
        onSuccess: () => {
            showModal.value = false;
            form.reset();
        },
    });
};
</script>

<style scoped></style>
