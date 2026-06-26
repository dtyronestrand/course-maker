<template>
    <AppLayout>
        <div class="mt-4 flex flex-row justify-between">
            <h2 class="text-2xl font-semibold">Courses</h2>
            <Button v-if="page.props.user_role === 'admin' || page.props.user_role === 'lead'" @click="showCreateCourseModal = true">+ Course</Button>
        </div>
        <div class="rounded-xl p-4">
         <component :is="courseComponent" :courses="page.props.courses"/>
        </div>
        <CreateCourse
            v-if="showCreateCourseModal"
            @create-course="saveCourse"
            @close="showCreateCourseModal = false"
        />
    </AppLayout>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Course } from '@/types';
import type { PageProps as InertiaPageProps } from '@inertiajs/core';
import CreateCourse from '@/components/courses/CreateCourse.vue';
import { defineAsyncComponent, ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

interface PageProps extends InertiaPageProps {
    courses: Course[];
    developmentCycles: Array<any>;
}
const page = usePage<PageProps>();
const showCreateCourseModal = ref(false);
const saveCourse = (courseData: {
    prefix: string;
    number: string;
    name: string;
    development_cycle_id: number;
}) => {
    // Send a POST request to create the course
    router.post('/courses', courseData, {
        onSuccess: () => {
            showCreateCourseModal.value = false;
        },
    });
};

const courseTable = defineAsyncComponent(() => import('@/components/CourseTable.vue'));
const courseList = defineAsyncComponent(() => import('@/components/courses/CourseList.vue'));
const courseComponent = computed(() =>
    page.props.user_role === 'admin' || page.props.user_role === 'lead' ? courseTable : courseList
);
</script>

<style scoped></style>
