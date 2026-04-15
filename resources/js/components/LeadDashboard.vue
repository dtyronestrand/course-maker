<template>
   <div class="mt-4 flex grow flex-col">
        <div class="wrapper h-full p-2">
            <div class="mb-6 grid grid-cols-4 gap-6">
                <div class="glass rounded-xl flex flex-col border max-h-80 !border-red-500/90 p-6">
                    <div class="flex items-start justify-between shrink-0">
                        <h2 class="font-semi-bold text-lg uppercase">
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
                <div class="glass rounded-xl flex flex-col border max-h-80 min-h-80 !border-amber-500/90 p-8">
                <div class="flex items-start justify-between shrink-0">
                <h2 class="font-semibold text-lg uppercase">Tasks</h2>
                <LayoutList class="h-10 w-10 text-amber-500" />
                </div>
                </div>
                <div class="glass rounded-xl flex flex-col col-span-2 border max-h-89 min-h-80 !border-yellow-400/90 p-8">
                <div class="flex items-start justify-between shrink-0">
                <h2 class="font-semibold text-lg uppercase">Messages</h2>
                <Mail class="h-10 w-10 text-yellow-400" />
                </div>
                </div>
                </div>
                <div class="grid grid-cols-3 gap-6">
                <div class="glass rounded-xl flex flex-col col-span-1 border min-h-120 max-h-120 !border-green-500/90 p-8">
                <div class="flex items-start justify-between shrink-0">
                <h2 class="font-semibold text-lg uppercase">Activity Feed</h2>
                <Rss class="h-10 w-10 text-green-500" />
                </div>
                </div>
                <div class="glass rounded-xl flex flex-col col-span-2 border min-h-120 max-h-120 !border-blue-500/90 p-8">
                <div class="flex items-start justify-between shrink-0">
                <h2 class="font-semibold text-lg uppercase">Team</h2>
                <Users class="h-10 w-10 text-blue-500" />
                </div>
                <div class="w-full grid grid-cols-2 overflow-y-auto gap-x-4">
                <div v-for="user in dashboardData.users" :key="user.id" class="mt-4 ">
                    <figure class="flex flex-col items-center p-12 bg-amber-700 gap-4">
                    <img :src="user.avatar_url" alt="User Avatar" class="h-12 w-12 rounded-full object-cover" />
                    <figcaption class="text-sm font-medium">
                        {{ user.first_name }} {{ user.last_name }}
                    </figcaption>
                    </figure>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
              
</template>

<script setup lang="ts">
import type { Course } from '@/types';
import {
    TriangleAlert,
    Rss,
    LayoutList,
    Mail,
    Users,
} from 'lucide-vue-next';
import axios from 'axios';
import type { PageProps } from '@inertiajs/core';
import CourseNeedsAttentionDetails from './courses/CourseNeedsAttentionDetails.vue';
interface LeadDashboardPageProps extends PageProps {
    courses: Course[];
}
defineProps<LeadDashboardPageProps>();
    import { onMounted, ref } from 'vue';
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
const getLeadDashboardData = async () => {
    try {
        const response = await axios.get('/api/lead-dashboard');
        dashboardData.value = response.data;
        console.log('Dashboard data:', response.data);
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};
onMounted(() => {
    // Fetch data for the dashboard
    getLeadDashboardData();
});
</script>

<style scoped>

</style>