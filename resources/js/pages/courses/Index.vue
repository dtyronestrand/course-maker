<template>
    <AppLayout>
    <div class="flex flex-row justify-between mt-4">
    <h2 class="text-2xl font-semibold text-amber-500">Courses</h2>
    <Button @click="showCreateCourseModal = true">+ Course</Button>
    </div>
     <CourseTable :courses="page.props.courses" :developmentCycles="page.props.developmentCycles" />
    <CreateCourse v-if="showCreateCourseModal" @create-course="saveCourse" @close="showCreateCourseModal = false" />
    </AppLayout>
</template>

<script setup lang="ts">
import {usePage} from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import CourseTable from '@/components/CourseTable.vue';
import type { Course } from '@/types';
import type { PageProps as InertiaPageProps } from '@inertiajs/core';
import CreateCourse from '@/components/courses/CreateCourse.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

interface PageProps extends InertiaPageProps {
    courses: Course[];
    developmentCycles: Array<any>;
}
const page = usePage<PageProps>();
const showCreateCourseModal = ref(false);
const saveCourse = (courseData: { prefix: string; number: string; name: string; development_cycle_id: number }) => {
    // Send a POST request to create the course
    router.post('/courses', courseData, {
        onSuccess: () => {
            showCreateCourseModal.value = false;
        }
    });
};
</script>

<style scoped>

</style>