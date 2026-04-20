<template>
    <AppLayout>
        <Head title="My Team" />
        <h1 class="mb-4 text-2xl font-bold">{{ page.props.team.name }}</h1>
        <div
            v-for="member in localMembers"
            :key="member.id"
            class="glass m-4 max-w-[30%] rounded-2xl p-4"
        >
            <div class="flex flex-row justify-between">
                <h2 class="text-xl font-semibold">{{ member.name }}</h2>
                <p class="text-md uppercase">
                    {{ member.roles?.map((role) => role.name).join(', ') }}
                </p>
            </div>
            <div class="flex flex-col">
                <div
                    v-for="course in member.courses"
                    :key="course.id"
                    class="mt-2 flex flex-row items-center"
                >
                    <p>{{ course.prefix }}</p>
                    &nbsp;
                    <p>{{ course.number }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Team, User } from '@/types';
import { ref } from 'vue';
import type { PageProps as InertiaPageProps } from '@inertiajs/core';
interface PageProps extends InertiaPageProps {
    members: User[];
    team: Team;
}
const page = usePage<PageProps>();

const localMembers = ref<User[]>(page.props.members);
</script>

<style scoped></style>
