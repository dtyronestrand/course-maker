<template>
    <ul class="flex flex-row gap-4">
        <li class="w-[25%]" v-for="course in props.courses" :key="course.id">
            <div
                class="course-card glass flex h-full cursor-pointer flex-col flex-wrap border border-primary! p-4 outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2"
                role="button"
                tabindex="0"
                :aria-label="`View details for ${course.prefix} ${course.number}: ${course.title}`"
                @click="courseDetails(course)"
                @keydown.enter="courseDetails(course)"
                @keydown.space.prevent="courseDetails(course)"
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
                <section class="mt-4">
                    <h3>Deliverables:</h3>
                    <ol class="list-decimal pl-6">
                        <li
                            v-for="deliverable in course.deliverables"
                            :key="deliverable.id"
                            class="flex list-item flex-row gap-4"
                        >
                            <p
                                :style="{
                                    textDecoration: deliverable.pivot.is_done
                                        ? 'line-through'
                                        : 'none',
                                }"
                            >
                                {{ deliverable.name }}
                            </p>
                        </li>
                    </ol>
                </section>
            </div>
        </li>
    </ul>
</template>

<script setup lang="ts">
import type { Course } from '@/types';
import { router } from '@inertiajs/vue3';
interface Props {
    courses: Course[];
}

const props = defineProps<Props>();
const courseDetails = (course: Course) => {
    router.get(`/courses/${course.id}`);
};
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
