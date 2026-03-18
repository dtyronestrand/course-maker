<template>
    <div
        v-if="props.isOpen"
        class="fixed inset-0 z-50 flex h-screen justify-center bg-slate-500/50 backdrop-blur-sm"
        @click.self="emit('modal-close')"
    >
        <div
            class="pointer-events-auto w-full max-h-screen overflow-y-auto max-w-xl rounded-lg border border-primary glass p-6 shadow-lg shadow-primary"
            ref="target"
        >
            <h1 class="text-center text-3xl font-bold">Edit</h1>

            <form
                class="flex flex-col flex-wrap gap-4"
                @submit.prevent="updateCourse"
            >
                <div class="flex flex-row justify-evenly mt-4">
                    <label for="prefix">Course Prefix:</label>
                    <input
                        class=" border border-primary bg-base-200 px-4"
                        type="text"
                        name="prefix"
                        v-model="localCourse.prefix"
                    />
                </div>
                <div class="flex flex-row items-center justify-evenly">
                    <label for="number">Course Number:</label>
                    <input
                        class="my-4 border border-primary bg-base-200 px-4"
                        type="text"
                        name="number"
                        v-model="localCourse.number"
                    />
                </div>

                <label for="title">Course Title:</label>
                <input
                    class="my-4 border border-primary bg-base-200 px-4"
                    type="text"
                    name="title"
                    v-model="localCourse.title"
                />
                <div class="mb-4">
                    <label
                        for="notes"
                        class="block text-sm font-medium text-base-content"
                        >Notes</label
                    >
                    <textarea
                        v-model="localCourse.notes"
                        id="notes"
                        class="my-4 h-24 w-full border border-primary bg-base-200 px-4"
                    ></textarea>
                </div>
                <div class="mb-4">
                    <label
                        for="cycle"
                        class="block text-sm font-medium text-base-content"
                        >Development Cycle</label
                    >
                    <select
                        v-model="localCourse.development_cycle.id"
                        id="cycle"
                        class="my-4 border border-primary bg-base-200 px-4"
                    >
                        <option :value="null">Select a cycle</option>
                        <option
                            v-for="cycle in developmentCycles"
                            :key="cycle.id"
                            :value="cycle.id"
                        >
                            {{ cycle.name }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-base-content mb-4">
                        Team Roles
                    </label>
                    <div class="overflow-x-auto">
                        <table class="w-full border border-primary">
                            <thead>
                                <tr class="bg-base-200">
                                    <th class="border border-primary p-2 text-left">Designer</th>
                                    <th class="border border-primary p-2 text-left">Lead</th>
                                    <th class="border border-primary p-2 text-left">SME</th>
                                    <th class="border border-primary p-2 text-left">Builder</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-primary p-2">
                                        <select
                                            v-model="selectedRoles.designer"
                                            @change="updateCourseUsers"
                                            class="bg-base-200 text-base-content w-full border border-primary p-2"
                                        >
                                            <option :value="null">Select Designer</option>
                                            <option
                                                v-for="user in ids"
                                                :key="user.id"
                                                :value="user.id"
                                            >
                                                {{ user.name }}
                                            </option>
                                        </select>
                                    </td>
                                    <td class="border border-primary p-2">
                                        <select
                                            v-model="selectedRoles.lead"
                                            @change="updateCourseUsers"
                                            class="bg-base-200 text-base-content w-full border border-primary p-2"
                                        >
                                            <option :value="null">Select Lead</option>
                                            <option
                                                v-for="user in leads"
                                                :key="user.id"
                                                :value="user.id"
                                            >
                                                {{ user.name }}
                                            </option>
                                        </select>
                                    </td>
                                    <td class="border border-primary p-2">
                                        <select
                                            v-model="selectedRoles.sme"
                                            @change="updateCourseUsers"
                                            class="bg-base-200 text-base-content w-full border border-primary p-2"
                                        >
                                            <option :value="null">Select SME</option>
                                            <option
                                                v-for="user in smes"
                                                :key="user.id"
                                                :value="user.id"
                                            >
                                                {{ user.name }}
                                            </option>
                                        </select>
                                    </td>
                                    <td class="border border-primary p-2">
                                        <select
                                            v-model="selectedRoles.builder"
                                            @change="updateCourseUsers"
                                            class="bg-base-200 text-base-content w-full border border-primary p-2"
                                        >
                                            <option :value="null">Select Builder</option>
                                            <option
                                                v-for="user in ids"
                                                :key="user.id"
                                                :value="user.id"
                                            >
                                                {{ user.name }}
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4 flex flex-row gap-4">
                    <button
                        type="submit"
                        class="btn text-success-content btn-success hover:bg-success/30 active:bg-success/50"
                    >
                        Save Changes
                    </button>
                    <button
                        type="button"
                        class="text-success-error btn btn-error hover:bg-error/30 active:bg-error/50"
                        @click="emit('modal-close')"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup lang="ts">
import type { Course, User } from '@/types';
import { router } from '@inertiajs/vue3';
import { onClickOutside } from '@vueuse/core';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';




const props = defineProps<{
    isOpen: boolean;
    course: Course;
}>();
const localCourse = ref<Course>(props.course);
const emit = defineEmits(['modal-close']);

const target = ref(null);
const ids = ref<User[]>([]);
const smes = ref<User[]>([]);
const leads = ref<User[]>([]);
const developmentCycles = ref<any[]>([]);

const selectedRoles = ref({
    designer: null as number | null,
    lead: null as number | null,
    sme: null as number | null,
    builder: null as number | null,
});

const updateCourseUsers = () => {
    const newUsers: User[] = [];
    
    if (selectedRoles.value.designer) {
        const designer = ids.value.find(u => u.id === selectedRoles.value.designer);
        if (designer) {
            newUsers.push({ ...designer, pivot: { role: 'Designer' } });
        }
    }
    
    if (selectedRoles.value.lead) {
        const lead = leads.value.find(u => u.id === selectedRoles.value.lead);
        if (lead) {
            newUsers.push({ ...lead, pivot: { role: 'Lead' } });
        }
    }
    
    if (selectedRoles.value.sme) {
        const sme = smes.value.find(u => u.id === selectedRoles.value.sme);
        if (sme) {
            newUsers.push({ ...sme, pivot: { role: 'SME' } });
        }
    }
    
    if (selectedRoles.value.builder) {
        const builder = ids.value.find(u => u.id === selectedRoles.value.builder);
        if (builder) {
            newUsers.push({ ...builder, pivot: { role: 'Builder' } });
        }
    }
    
    localCourse.value.users = newUsers;
};

const loadUsersByRole = async () => {
    try {
        const response = await axios.get('/api/users');
        const data = response.data;
        ids.value = data.ids;
        smes.value = data.smes;
        leads.value = data.leads;
        
        // Populate selected roles from existing course users
        if (localCourse.value.users && localCourse.value.users.length > 0) {
            localCourse.value.users.forEach(user => {
                switch (user.pivot?.role) {
                    case 'Designer':
                        selectedRoles.value.designer = user.id;
                        break;
                    case 'Lead':
                        selectedRoles.value.lead = user.id;
                        break;
                    case 'SME':
                        selectedRoles.value.sme = user.id;
                        break;
                    case 'Builder':
                        selectedRoles.value.builder = user.id;
                        break;
                }
            });
        }
    } catch (error) {
        console.error('Failed to fetch users:', error);
    }
};

const loadDevelopmentCycles = async () => {
    try {
        const response = await axios.get('/api/development-cycles');
        developmentCycles.value = response.data;
    } catch (error) {
        console.error('Failed to fetch development cycles:', error);
    }
};

// Watch for course prop changes to update local data
watch(() => props.course, (newCourse) => {
    localCourse.value = newCourse;
    if (newCourse.users && newCourse.users.length > 0) {
        // Reset and repopulate selected roles
        selectedRoles.value = {
            designer: null,
            lead: null,
            sme: null,
            builder: null,
        };
        
        newCourse.users.forEach(user => {
            switch (user.pivot?.role) {
                case 'Designer':
                    selectedRoles.value.designer = user.id;
                    break;
                case 'Lead':
                    selectedRoles.value.lead = user.id;
                    break;
                case 'SME':
                    selectedRoles.value.sme = user.id;
                    break;
                case 'Builder':
                    selectedRoles.value.builder = user.id;
                    break;
            }
        });
    }
}, { deep: true });

onMounted(() => {
    loadDevelopmentCycles();
    loadUsersByRole();
});

onClickOutside(target, () => {
    emit('modal-close');
});

const updateCourse = () => {
    console.log('localCourse.value before processing:', localCourse.value);
    console.log('localCourse.value.users before processing:', localCourse.value.users);
    
    const courseData = {
        prefix: localCourse.value.prefix,
        number: localCourse.value.number,
        title: localCourse.value.title,
        notes: localCourse.value.notes,
        development_cycle: localCourse.value.development_cycle,
        users: localCourse.value.users.map(user => ({
            id: user.id,
            role: user.pivot?.role
        }))
    };
    
    console.log('Sending course data:', courseData);
    console.log('Users data:', courseData.users);
    console.log('Users data detailed:', JSON.stringify(courseData.users, null, 2));
    
    router.put(`/courses/${localCourse.value.id}`, courseData, {
        onSuccess: () => {
            console.log('Course update successful');
            emit('modal-close');
        },
        onError: (errors) => {
            console.error('Course update failed:', errors);
        }
    });
};
</script>

<style scoped>
@reference '../../../css/app.css';
label {
    @apply text-xl font-bold;
}
input{
    @apply text-slate-950;
}
</style>