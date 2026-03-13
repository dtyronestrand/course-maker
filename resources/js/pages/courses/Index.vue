<template>
    <AppLayout>
    <div class="flex flex-row justify-between mt-4">
    <h2 class="text-2xl font-semibold text-amber-500">Courses</h2>
    <Button>+ Course</Button>
    </div>
     <CourseTable :courses="page.props.courses" :developmentCycles="page.props.developmentCycles" />

    </AppLayout>
</template>

<script setup lang="ts">
import {usePage} from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import CourseTable from '@/components/CourseTable.vue';
import type { Course } from '@/types';
import type { PageProps as InertiaPageProps } from '@inertiajs/core';

interface PageProps extends InertiaPageProps {
    courses: Course[];
    developmentCycles: Array<any>;
}
const page = usePage<PageProps>();

</script>

<style scoped>

</style>