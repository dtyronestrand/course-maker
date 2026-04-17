<template>
   <div class="mt-4 flex grow flex-col">
        <div class="wrapper h-full p-2">
            <div class="mb-6 grid grid-cols-4 gap-6">
                <div class="glass-card-card rounded-xl flex flex-col glow-border-red max-h-80  p-6">
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
                <div class="glass-card-card rounded-xl flex flex-col max-h-80 min-h-80 glow-border-orange p-8">
                <div class="flex items-start justify-between shrink-0">
                <h2 class="font-semibold text-lg uppercase">Tasks</h2>
                <LayoutList class="h-10 w-10 text-amber-500" />
                </div>
                </div>
                <div class="glass-card-card rounded-xl flex flex-col col-span-2  max-h-89 min-h-80 glow-border-yellow p-8">
                <div class="flex items-start justify-between shrink-0">
                <h2 class="font-semibold text-lg uppercase">Messages</h2>
                <Mail class="h-10 w-10 text-yellow-400" />
                </div>
                </div>
                </div>
                <div class="grid grid-cols-3 gap-6">
                <div class="glass-card-card rounded-xl flex flex-col col-span-1 min-h-120 max-h-120 glow-border-green p-8">
                <div class="flex items-start justify-between shrink-0">
                <h2 class="font-semibold text-lg uppercase">Activity Feed</h2>
                <Rss class="h-10 w-10 text-green-500" />
                </div>
                </div>
                <div class="glass-card-card glow-border-blue rounded-xl flex flex-col col-span-2 min-h-120 max-h-120 pb-0 p-8">
                <div class="flex items-start justify-between shrink-0">
                <h2 class="font-semibold text-lg uppercase">Team</h2>
                <Users class="h-10 w-10 text-blue-500" />
                </div>
                <div class="grid grid-cols-2 mt-4 xl:grid-cols-4 overflow-y-auto gap-4">
              
<div v-for="user in dashboardData.users" :key="user.id" class="glass-card-card-inner rounded-3xl p-4 flex flex-col items-center text-center hover:scale-[1.02] transition-transform">
<div class="w-24 h-24 rounded-full p-1 bg-gradient-to-tr from-amber-400 to-slate-500 mb-4 shadow-xl">
<img v-if="user.avatar" :alt="user.name" class="w-full h-full rounded-full object-cover border-4 border-slate-900 " :src="user.avatar"/>
<div v-else class="w-full h-full rounded-full border-4 border-slate-900 text-slate-950 text-xl flex items-center justify-center">{{ getInitials(user.name) }}</div>
</div>
<h3 class="text-md font-bold text-white">{{user.first_name}} {{user.last_name}}</h3>
<p class="text-sm text-white mt-1">{{user.roles[0].name.toUpperCase()}}</p>
<div v-if="user.courses?.length" class="mt-2 w-full text-left space-y-1">
    <div v-for="course in user.courses" :key="course.id" class="text-xs text-slate-300 flex justify-between">
        <span>{{ course.prefix }} {{ course.number }}</span>
        <span class="text-slate-400 capitalize">{{ course.pivot.role }}</span>
    </div>
</div>
</div>
                </div>
                </div>
                </div>
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
import {useInitials} from '@/composables/useInitials';
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
const { getInitials } = useInitials();
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

const styleByStatus = (status: string) => {
    switch(status){
        case 'pending':
            return 'bg-yellow-500/20 text-yellow-400 border-yellow-400/50';
  
        case 'design':
            return 'bg-blue-500/20 text-blue-400 border-blue-400/50';
  
        case 'completed':
            return 'bg-green-500/20 text-green-400 border-green-400/50';
      
        default:
            return 'bg-gray-500/20 text-gray-400 border-gray-400/50';
    }
}
</script>

<style scoped>

</style>