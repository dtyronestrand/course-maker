<template>
    <ul class="flex flex-row gap-4">
        <li
            class="course-card glass flex w-[25%] flex-col flex-wrap border border-primary! p-4"
            v-for="course in props.courses"
            :key="course.id"
        >
            <header>
                <h2>{{ course.prefix }} {{ course.number }}</h2>
                <p>{{ course.title }}</p>
            </header>
            <section class="mt-8 grid grid-cols-2">
                <h3 class="">Status:</h3>
                <p
                    class="w-[6rem] rounded-full bg-primary text-center text-[var(--on-primary)]"
                >
                    {{ course.status }}
                </p>
            </section>
        </li>
    </ul>
</template>

<script setup lang="ts">
import type { Course } from '@/types';

interface Props {
    courses: Course[];
}

const props = defineProps<Props>();
</script>

<style scoped>
.course-card:hover {
    background-color: rgb(from var(--tertiary) r g b / 0.2);
}
.course-card:active {
    box-shadow: none;
    transform: translateY(5px);
}
</style>
