<template>
    <div
        class="pointer-events-none fixed inset-0 z-50 flex items-center justify-center bg-slate-600/70"
        @click.self="$emit('close')"
    >
        <div
            class="glass pointer-events-auto mx-4 w-full max-w-xl overflow-y-auto rounded-lg border-2 border-amber-500 p-6 shadow-lg shadow-primary"
        >
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-base-content text-xl font-semibold">
                    Create Course
                </h2>
                <button
                    @click="$emit('close')"
                    class="text-primary-content hover:text-error"
                    aria-label="Close modal"
                >
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="var(--color-error)"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </button>
            </div>
            <form @submit.prevent="handleCreateCourse">
                <div class="mb-4">
                    <label
                        for="prefix"
                        class="text-base-content block text-sm font-medium"
                        >Course Prefix</label
                    >
                    <input
                        v-model="courseData.prefix"
                        type="text"
                        id="prefix"
                        class="mt-1 block w-full border border-primary p-2"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="number"
                        class="text-base-content block text-sm font-medium"
                        >Course Number</label
                    >
                    <input
                        v-model="courseData.number"
                        type="text"
                        id="number"
                        class="bg-base-200 mt-1 block w-full border border-primary p-2"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="title"
                        class="text-base-content block text-sm font-medium"
                        >Course Title</label
                    >
                    <input
                        v-model="courseData.title"
                        type="text"
                        id="title"
                        class="bg-base-200 mt-1 block w-full border border-primary p-2"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="cycle"
                        class="text-base-content block text-sm font-medium"
                        >Development Cycle</label
                    >
                    <select
                        v-model="courseData.development_cycle"
                        id="cycle"
                        class="bg-base-200 text-base-content mt-1 block w-full border border-primary p-2"
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
                    <label
                        for="objectives"
                        class="text-base-content mb-4 block text-sm font-medium"
                        >Course Objectives</label
                    >
                    <div
                        v-for="(objective, index) in courseData.objectives"
                        :key="index"
                        class="mb-2 flex flex-col gap-2"
                    >
                        <div class="flex items-center gap-2">
                            <p class="mb-0">{{ objective.number }}.</p>
                            <input
                                v-model="objective.objective"
                                type="text"
                                :id="'objective-' + index"
                                class="bg-base-200 mt-1 block w-full border border-primary p-2"
                            />
                            <button
                                type="button"
                                @click="courseData.objectives.splice(index, 1)"
                                class="frosted-backdrop min-height-[3.75em] min-width-0 decoration-none transition-[all cubic-bezier(.23,1, 0.32,1)] user-select-none hover:shadow-[rgba(0,0,0,0.25) 0 8px 15px] border-error bg-error/10 text-error hover:text-secondary-content m-0 box-border inline-block -translate-y-0.5 cursor-pointer touch-manipulation appearance-none rounded-[0.9375em] border px-[1.5em] py-[0.25em] text-center font-bold duration-300 will-change-transform outline-none hover:bg-secondary active:translate-y-0 active:shadow-none disabled:pointer-events-none"
                                aria-label="Remove objective"
                            >
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="createObjective"
                        class="min-height-[3.75em] min-width-0 decoration-none transition-[all cubic-bezier(.23,1, 0.32,1)] user-select-none hover:shadow-[rgba(0,0,0,0.25) 0 8px 15px] text-primary-content m-0 mt-4 box-border inline-block -translate-y-0.5 cursor-pointer touch-manipulation appearance-none rounded-lg bg-primary px-[1.5em] py-[0.25em] text-center font-bold duration-300 will-change-transform outline-none hover:bg-primary/30 active:translate-y-0 active:bg-primary/50 active:shadow-none disabled:pointer-events-none"
                    >
                        Add Objective
                    </button>
                </div>

                <div class="mb-4">
                    <label
                        class="text-base-content mb-4 block text-sm font-medium"
                    >
                        Team Roles
                    </label>
                    <div class="overflow-x-auto">
                        <table class="w-full border border-primary">
                            <thead>
                                <tr class="bg-base-200">
                                    <th
                                        class="border border-primary p-2 text-left"
                                    >
                                        Designer
                                    </th>
                                    <th
                                        class="border border-primary p-2 text-left"
                                    >
                                        Lead
                                    </th>
                                    <th
                                        class="border border-primary p-2 text-left"
                                    >
                                        SME
                                    </th>
                                    <th
                                        class="border border-primary p-2 text-left"
                                    >
                                        Builder
                                    </th>
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
                                            <option :value="null">
                                                Select Designer
                                            </option>
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
                                            <option :value="null">
                                                Select Lead
                                            </option>
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
                                            <option :value="null">
                                                Select SME
                                            </option>
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
                                            <option :value="null">
                                                Select Builder
                                            </option>
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
                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="min-height-[3.75em] min-width-0 decoration-none transition-[all cubic-bezier(.23,1, 0.32,1)] user-select-none hover:shadow-[rgba(0,0,0,0.25) 0 8px 15px] bg-success text-success-content hover:bg-success/30 active:bg-success/50 m-0 mt-4 box-border inline-block -translate-y-0.5 cursor-pointer touch-manipulation appearance-none rounded-lg px-[1.5em] py-[0.25em] text-center font-bold duration-300 will-change-transform outline-none active:translate-y-0 active:shadow-none disabled:pointer-events-none"
                    >
                        Create Course
                    </button>
                    <button
                        type="button"
                        @click="$emit('close')"
                        class="min-height-[3.75em] min-width-0 decoration-none transition-[all cubic-bezier(.23,1, 0.32,1)] user-select-none hover:shadow-[rgba(0,0,0,0.25) 0 8px 15px] bg-error text-error-content hover:bg-error/30 active:bg-error/50 m-0 mt-4 box-border inline-block -translate-y-0.5 cursor-pointer touch-manipulation appearance-none rounded-lg px-[1.5em] py-[0.25em] text-center font-bold duration-300 will-change-transform outline-none active:translate-y-0 active:shadow-none disabled:pointer-events-none"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import type { DevelopmentCycle } from '@/types';

const emit = defineEmits(['create-course', 'close']);

interface User {
    id: number;
    name: string;
    role?: string;
}

interface Objective {
    number: string;
    objective: string;
}

interface CourseData {
    prefix: string;
    number: string;
    title: string;
    objectives: Objective[];
    users: User[];
    development_cycle: number | null;
}

const ids = ref<User[]>([]);
const smes = ref<User[]>([]);
const leads = ref<User[]>([]);
const users = ref<User[]>([]);

const developmentCycles = ref<DevelopmentCycle[]>([]);
const courseData = ref<CourseData>({
    prefix: '',
    number: '',
    title: '',
    objectives: [],
    users: [],
    development_cycle: null,
});

const selectedRoles = ref({
    designer: null as number | null,
    lead: null as number | null,
    sme: null as number | null,
    builder: null as number | null,
});

const handleCreateCourse = () => {
    const filteredObjectives = courseData.value.objectives.filter(
        (obj) => obj.objective.trim() !== '',
    );
    const courseToCreate = {
        ...courseData.value,
        objectives: filteredObjectives,
    };
    emit('create-course', courseToCreate);
    // Reset the form
    courseData.value = {
        prefix: '',
        number: '',
        title: '',
        objectives: [],
        users: [],
        development_cycle: null,
    };
    selectedRoles.value = {
        designer: null,
        lead: null,
        sme: null,
        builder: null,
    };
};

const toRoman = (num: number): string => {
    if (typeof num !== 'number' || num <= 0 || !Number.isInteger(num)) {
        return '';
    }

    const lookup: Record<string, number> = {
        M: 1000,
        CM: 900,
        D: 500,
        CD: 400,
        C: 100,
        XC: 90,
        L: 50,
        XL: 40,
        X: 10,
        IX: 9,
        V: 5,
        IV: 4,
        I: 1,
    };

    let roman = '';
    for (const key in lookup) {
        while (num >= lookup[key]) {
            roman += key;
            num -= lookup[key];
        }
    }
    return roman;
};

const updateCourseUsers = () => {
    const newUsers: User[] = [];

    if (selectedRoles.value.designer) {
        const designer = ids.value.find(
            (u) => u.id === selectedRoles.value.designer,
        );
        if (designer) {
            newUsers.push({ ...designer, role: 'Designer' });
        }
    }

    if (selectedRoles.value.lead) {
        const lead = leads.value.find((u) => u.id === selectedRoles.value.lead);
        if (lead) {
            newUsers.push({ ...lead, role: 'Lead' });
        }
    }

    if (selectedRoles.value.sme) {
        const sme = smes.value.find((u) => u.id === selectedRoles.value.sme);
        if (sme) {
            newUsers.push({ ...sme, role: 'SME' });
        }
    }

    if (selectedRoles.value.builder) {
        const builder = ids.value.find(
            (u) => u.id === selectedRoles.value.builder,
        );
        if (builder) {
            newUsers.push({ ...builder, role: 'Builder' });
        }
    }

    courseData.value.users = newUsers;
};
const createObjective = () => {
    courseData.value.objectives.push({
        number: toRoman(courseData.value.objectives.length + 1),
        objective: '',
    });
};

onMounted(async () => {
    try {
        const response = await fetch('/api/users', {
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
        });
        const data = await response.json();
        ids.value = data.ids;
        smes.value = data.smes;
        leads.value = data.leads;
        users.value = [...data.ids, ...data.smes, ...data.leads];
        developmentCycles.value = data.cycles || [];

        // If editing existing course, populate selected roles
        if (courseData.value.users.length > 0) {
            courseData.value.users.forEach((user) => {
                switch (user.role) {
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
        console.error('Failed to fetch data:', error);
    }
});
</script>

<style scoped>
.pointer-events-none {
    pointer-events: none;
}
.pointer-events-auto {
    pointer-events: auto;
}
input {
    color: var(--slate-900);
}
</style>
