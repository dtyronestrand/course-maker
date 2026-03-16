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

                <ul
                    class="mt-4 flex flex-row flex-wrap gap-4"
                >
                    <li
                        class="flex flex-col items-center justify-center gap-2"
                        v-for="(user, index) in course.users"
                        :key="user.id"
                    >
                        <div
                            class=" flex h-8 w-8 items-center justify-center rounded-full border border-primary p-4 text-primary shadow shadow-primary"
                        >
                            {{ getInitials(user.name) }}
                        </div>
                        <select
                            v-model="user.pivot!.role"
                            class="my-4 border border-primary bg-base-200 px-4"
                        >
                            <option value="Designer">Designer</option>
                            <option value="SME">Subject Matter Expert</option>
                            <option value="Manager">Manager</option>
                            <option value="Builder">Builder</option>
                        </select>
                        <button
                            type="button"
                            @click="localCourse.users.splice(index, 1)"
                            class="font-bold text-error"
                        >
                            X
                        </button>
                    </li>
                </ul>
                <ul>
                    <li v-if="!showAddUser && localCourse.users.length < 4">
                        <button
                            type="button"
                            class="btn text-primary-content btn-primary hover:bg-primary/30 active:bg-primary/50"
                            @click="handleShowAddUser"
                        >
                            Add User
                        </button>
                    </li>
                    <li v-if="showAddUser" class="flex flex-col gap-2">
                        <select
                            v-model="selectedUserId"
                            class="my-4 border border-primary bg-base-200 px-4"
                        >
                            <option :value="null">Select User</option>
                            <option
                                v-for="user in availableUsers"
                                :key="user.id"
                                :value="user.id"
                            >
                                {{user.name}}
                            </option>
                        </select>
                        <select
                            v-model="selectedRole"
                            class="my-4 border border-primary bg-base-200 px-4"
                        >
                            <option value="Designer">Designer</option>
                            <option value="SME">Subject Matter Expert</option>
                            <option value="Manager">Manager</option>
                            <option value="Builder">Builder</option>
                        </select>
                        <div class="flex gap-2">
                            <button
                                type="button"
                                @click="() => { console.log('Add button clicked', { selectedUserId: selectedUserId, selectedRole: selectedRole }); addUser(); }"
                                class="btn text-success-content btn-success"
                            >
                                Add
                            </button>
                            <button
                                type="button"
                                @click="cancelAddUser"
                                class="btn text-error-content btn-error"
                            >
                                Cancel
                            </button>
                        </div>
                    </li>
                </ul>
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
import { useInitials } from '@/composables/useInitials';
import type { Course } from '@/types';
import { router } from '@inertiajs/vue3';
import { onClickOutside } from '@vueuse/core';
import axios from 'axios';
import { onMounted, ref } from 'vue';
const { getInitials } = useInitials();
const props = defineProps<{
    isOpen: boolean;
    course: Course;
}>();
const localCourse = ref<Course>(props.course);
const emit = defineEmits(['modal-close']);

const target = ref(null);
const showAddUser = ref(false);
const selectedUserId = ref<number | null>(null);
const selectedRole = ref('Designer');
const availableUsers = ref<any[]>([]);
const developmentCycles = ref<any[]>([]);

const addUser = () => {
    if (!selectedUserId.value) return;

    const user = availableUsers.value.find(
        (u) => u.id === selectedUserId.value,
    );
    if (user) {
        console.log('Adding user to localCourse:', user, 'with role:', selectedRole.value);
        localCourse.value.users.push({
            ...user,
            pivot: { role: selectedRole.value },
        });
        console.log('Updated localCourse.users:', localCourse.value.users);
        cancelAddUser();
    }
};

const cancelAddUser = () => {
    showAddUser.value = false;
    selectedUserId.value = null;
    selectedRole.value = 'Designer';
};

const loadAvailableUsers = async () => {
    const response = await axios.get('/api/allUsers');
    const existingUserIds = new Set(localCourse.value.users.map((u) => u.id));
    availableUsers.value = response.data.filter(
        (user: any) => !existingUserIds.has(user.id),
    );
};

const loadDevelopmentCycles = async () => {
    const response = await axios.get('/api/development-cycles');
    developmentCycles.value = response.data;
};

onMounted(() => {
    loadDevelopmentCycles();
    
});
const handleShowAddUser = async () => {
    console.log('handleShowAddUser called');
    await loadAvailableUsers();
    console.log('Available users loaded:', availableUsers.value);
    showAddUser.value = true;
    console.log('showAddUser set to true');
};
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