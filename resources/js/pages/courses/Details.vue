<template>
    <AppLayout>
    <div class="bg-[var(--tertiary)] text-[var(--on-tertiary)] p-4">
        <header class="relative m-[3rem 0] mb-4">
        <h1>{{ props.course.prefix }} {{ props.course.number }}</h1>
        <p>{{ props.course.title }}</p>
        </header>
        <section>
        <h2>Objectives</h2>
        <ul>
        <li v-for="objective in props.course.course_objectives" :key="objective.id">
        {{ objective.number }}. {{ objective.objective }}
        </li>
        </ul>
        </section>
    </div>
    </AppLayout>
</template>

<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import type { Course } from '@/types';

    interface Props {
        course: Course;
    }

    const props = defineProps<Props>();

</script>

<style lang="scss" scoped>

</style>