<template>
    <div class="mt-4 flex grow flex-col">
        <div class="wrapper h-full p-2">
            <div class="mb-6 grid grid-cols-4 gap-6">
                <div
                    class="glass-card-card glow-border-red flex max-h-80 flex-col rounded-xl p-6"
                >
                    <div class="flex shrink-0 items-start justify-between">
                        <h2 class="font-semi-bold text-lg uppercase">
                            Needs Attention
                        </h2>
                        <TriangleAlert class="h-10 w-10 text-red-500" />
                    </div>
                    <div class="min-h-0 flex-1 overflow-y-auto">
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
                <div
                    class="glass-card-card glow-border-orange flex max-h-80 min-h-80 flex-col rounded-xl p-8"
                >
                    <div class="flex shrink-0 items-start justify-between">
                        <h2 class="text-lg font-semibold uppercase">Tasks</h2>
                        <LayoutList class="h-10 w-10" />
                    </div>
                </div>
                <div
                    class="glass-card-card glow-border-yellow col-span-2 flex max-h-89 min-h-80 flex-col rounded-xl p-8"
                >
                    <div class="flex shrink-0 items-start justify-between">
                        <h2 class="text-lg font-semibold uppercase">
                            Messages
                        </h2>
                        <Mail class="h-10 w-10 text-yellow-400" />
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-6">
                <div
                    class="glass-card-card glow-border-green col-span-1 flex max-h-120 min-h-120 flex-col rounded-xl p-8"
                >
                    <div class="flex shrink-0 items-start justify-between">
                        <h2 class="text-lg font-semibold uppercase">
                            Activity Feed
                        </h2>
                        <Rss class="h-10 w-10 text-green-500" />
                    </div>
                </div>
                <div
                    class="glass-card-card glow-border-blue col-span-2 flex max-h-120 min-h-120 flex-col rounded-xl p-8 pb-0"
                >
                    <div class="flex shrink-0 items-start justify-between">
                        <h2 class="text-lg font-semibold uppercase">Team</h2>
                        <Users class="h-10 w-10 text-blue-500" />
                    </div>
                    <div
                        class="mt-4 grid grid-cols-2 gap-4 overflow-y-auto xl:grid-cols-4"
                    >
                        <div
                            v-for="user in dashboardData.users"
                            :key="user.id"
                            class="glass-card-card-inner flex flex-col items-center rounded-3xl p-4 text-center transition-transform hover:scale-[1.02]"
                        >
                            <div
                                class="mb-4 h-24 w-24 rounded-full bg-gradient-to-tr from-amber-400 to-slate-500 p-1 shadow-xl"
                            >
                                <img
                                    v-if="user.avatar"
                                    :alt="user.name"
                                    class="h-full w-full rounded-full border-4 border-slate-900 object-cover"
                                    :src="user.avatar"
                                />
                                <div
                                    v-else
                                    class="flex h-full w-full items-center justify-center rounded-full border-4 border-slate-900 text-xl text-slate-950"
                                >
                                    {{ getInitials(user.name) }}
                                </div>
                            </div>
                            <h3 class="text-md font-bold text-white">
                                {{ user.first_name }} {{ user.last_name }}
                            </h3>
                            <p class="mt-1 text-sm text-white">
                                {{ user.roles[0].name.toUpperCase() }}
                            </p>
                            <div
                                v-if="user.courses?.length"
                                class="mt-2 w-full space-y-1 text-left"
                            >
                                <div
                                    v-for="course in user.courses"
                                    :key="course.id"
                                    class="flex justify-between text-xs text-slate-300"
                                >
                                    <span
                                        >{{ course.prefix }}
                                        {{ course.number }}</span
                                    >
                                    <span class="text-slate-400 capitalize">{{
                                        course.pivot.role
                                    }}</span>
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
import { useInitials } from '@/composables/useInitials';
import { TriangleAlert, Rss, LayoutList, Mail, Users } from 'lucide-vue-next';
import { useHttp } from '@inertiajs/vue3';
import type { PageProps } from '@inertiajs/core';
import CourseNeedsAttentionDetails from './courses/CourseNeedsAttentionDetails.vue';
interface LeadDashboardPageProps extends PageProps {
    courses: Course[];
}
defineProps<LeadDashboardPageProps>();
import { onMounted, ref } from 'vue';
const isModalOpened = ref(false);
const selectedCourse = ref<any>(null);
const dashboardData = ref<any>({
    coursesNeedingAttention: [],
    activeCourseCount: 0,
    courseStatusCounts: [],
});
const openModal = (course: Course) => {
    selectedCourse.value = course;
    isModalOpened.value = true;
};
const { getInitials } = useInitials();
const closeModal = () => {
    isModalOpened.value = false;
    selectedCourse.value = null;
};

const http = useHttp();

const getLeadDashboardData = async () => {
    try {
        const response = await http.get('/api/lead-dashboard');
        dashboardData.value = response;
        console.log('Dashboard data:', response);
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};
onMounted(() => {
    // Fetch data for the dashboard
    getLeadDashboardData();
});

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const styleByStatus = (status: string) => {
    switch (status) {
        case 'pending':
            return 'bg-yellow-500/20 text-yellow-400 border-yellow-400/50';

        case 'design':
            return 'bg-blue-500/20 text-blue-400 border-blue-400/50';

        case 'completed':
            return 'bg-green-500/20 text-green-400 border-green-400/50';

        default:
            return 'bg-gray-500/20 text-gray-400 border-gray-400/50';
    }
};
</script>

<style scoped></style>
