<template>
    <div>
    <h1 class="mb-4 text-2xl font-bold">My Courses</h1>
        <CourseTable
            :courses="props.courses"
            :developmentCycles="props.developmentCycles"
        />
    </div>
</template>

<script setup lang="ts">
import type { Course } from '@/types';
import CourseTable from './CourseTable.vue';
 interface Props {
        courses: Course[];
    }
    const props = defineProps<Props>();

</script>
   
<style scoped></style>
