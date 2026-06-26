<template>
    <ul class="flex flex-row gap-4">
        <li class="course-card glass p-4 flex flex-col flex-wrap border border-primary! w-[25%]"  v-for="course in props.courses" :key="course.id" @click="courseDetails(course)">
        <header>
            <h2>{{ course.prefix }} {{ course.number }}</h2>
            <p>{{ course.title }}</p>
        </header>
        <section class="grid grid-cols-2 mt-8">
        <h3 class="">Status:</h3>
        <p class="bg-primary rounded-full text-center text-[var(--on-primary)] w-[6rem]">{{ course.status }}</p>
        </section>
        <section class="mt-4">
        <h3>Deliverables:</h3>
        <ol class="list-decimal pl-6">
        <li v-for="deliverable in course.deliverables" :key="deliverable.id" class="list-item flex flex-row gap-4">
        <p :style="{ textDecoration: deliverable.pivot.is_done ? 'line-through' : 'none' }">{{ deliverable.name }}</p>
        </li>
        </ol>
        </section>
        </li>
    </ul>
</template>

<script setup lang="ts">
import type { Course } from '@/types';
import {router} from '@inertiajs/vue3';
    interface Props {
        courses: Course[];
    }

    const props = defineProps<Props>();
    const courseDetails = (course: Course) => {
        router.get(`/courses/${course.id}`);
    }
</script>

<style scoped>
.course-card:hover {
    background-color: rgb(from var(--tertiary) r g b / 0.2);
}
.course-card:active {
    box-shadow:none;
    transform: translateY(5px);
}
</style>
