<template>
 
    <div class="mt-4 flex grow flex-col">
        <div class="wrapper h-full p-2">
            <div class="mb-6 grid grid-cols-4 gap-6">
                <div class="glass rounded-xl flex flex-col border max-h-80 !border-red-500/90 p-6">
                    <div class="flex items-start justify-between shrink-0">
                        <h2 class="font-semi-bold text-sm uppercase">
                            Needs Attention
                        </h2>
                        <TriangleAlert class="h-10 w-10 text-red-500" />
                    </div>
                    <div class="overflow-y-auto flex-1 min-h-0">
                    <ul class="mt-8 list-inside list-disc">
                        <li
                            v-for="course in dashboardData.coursesNeedingAttention"
                            :key="course.id"
                        >
                            <button
                                @click="openModal(course)"
                                class="mt-2 text-2xl hover:underline"
                            >
                                {{ course.prefix }} {{ course.number }}
                            </button>
                        </li>
                    </ul>
                    </div>
                </div>
                <div class="glass rounded-xl border max-h-80 !border-amber-500/70 p-6">
                    <div class="flex items-start justify-between">
                        <h2 class="font-semi-bold text-sm uppercase">
                            Project Status Distribution
                        </h2>
                        <ChartColumnBig class="h-10 w-10" />
                    </div>
                    <p class="text-md">
                        Total Active Courses:
                        {{ dashboardData.activeCourseCount }}
                    </p>
                    <CourseStatusChart
                        class="mt-4"
                        :courseStatusCounts="dashboardData.courseStatusCounts"
                    />
                </div>
                <div
                    class="glass rounded-xl border max-h-80 !border-blue-500/70 p-6 shadow-lg"
                >
                    <div class="flex items-start justify-between">
                        <h2 class="text-sm font-semibold uppercase">
                            Avg Course Completion Time (Days)
                        </h2>
                        <SquareChartGantt class="h-10 w-10 text-blue-500" />
                    </div>
                </div>
                <div
                    class="glass flex max-h-80 flex-col rounded-xl border !border-green-500/70 p-4 shadow-lg"
                >
                    <div class="flex items-start justify-between">
                        <h2 class="text-sm font-semibold uppercase">
                            Team Capacity
                        </h2>
                        <Users class="h-10 w-10 text-green-500" />
                    </div>
                    <div class="overflow-auto">
                        <TeamCapacityChart class="mt-4" />
                    </div>
                </div>
            </div>
            <div class="flex gap-6">
                <div class="glass flex-1 rounded-xl border p-8 shadow-lg">
                    <div clas="flex items-start justify-between ">
                        <h2 class="text-xl font-semibold uppercase">
                            Project Pipeline
                        </h2>
                    </div>
                    <ProjectPipelineTable :courses="courses" />
                </div>
            </div>
              <aside class="w-80 shrink-0">
                    <div
                        class="flex h-full flex-col rounded-xl border border-info/70 bg-base-100 p-6 shadow-lg shadow-info/20"
                    >
                        <h2 class="mb-6 text-xl font-semibold text-secondary">
                            Recent Activities
                        </h2>
                   
                    </div>
                </aside>
        </div>
    </div>
    <CourseNeedsAttentionDetails
        v-if="isModalOpened && selectedCourse"
        :isOpen="isModalOpened"
        :course="selectedCourse"
        @modal-close="closeModal"
    />
</template>

<script setup lang="ts">
import type { Course } from '@/types';
import ProjectPipelineTable from './ProjectPipelineTable.vue';
import CourseStatusChart from '@/components/courses/CourseStatusChart.vue';
import TeamCapacityChart from '@/components/TeamCapacityChart.vue';
import type { PageProps } from '@inertiajs/core';

import {
    ChartColumnBig,
    SquareChartGantt,
    TriangleAlert,
    Users,
} from 'lucide-vue-next';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import CourseNeedsAttentionDetails from './courses/CourseNeedsAttentionDetails.vue';
interface AdminDashboardPageProps extends PageProps {
    courses: Course[];
}
defineProps<AdminDashboardPageProps>();
const isModalOpened = ref(false);
const selectedCourse = ref<any>(null);
const dashboardData = ref<any>({ coursesNeedingAttention: [], activeCourseCount: 0, courseStatusCounts: [] });
const openModal = (course: Course) => {
    selectedCourse.value = course;
    isModalOpened.value = true;
};

const closeModal = () => {
    isModalOpened.value = false;
    selectedCourse.value = null;
};
const getAdminDashboardData = async () => {
    try {
        const response = await axios.get('/api/admin-dashboard');
        dashboardData.value = response.data;
        console.log('Dashboard data:', response.data);
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};
onMounted(() => {
    // Fetch data for the dashboard
    getAdminDashboardData();
});
</script>

<style scoped></style>
