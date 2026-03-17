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
                        class=" mt-1 block w-full border border-primary p-2"
                        required
                        @input="clientErrors.prefix = undefined"
                    />
                    <InputError class="input-error" :message="clientErrors.prefix" />
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
                        class="bg-base-200  mt-1 block w-full border border-primary p-2"
                        required
                        @input="clientErrors.number = undefined"
                    />
                    <InputError class="input-error" :message="clientErrors.number" />
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
                        @input="clientErrors.title = undefined"
                    />
                    <InputError class="input-error" :message="clientErrors.title" />
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
                        @change="clientErrors.development_cycle = undefined"
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
                    <InputError class="input-error" :message="clientErrors.development_cycle" />
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
                                @input="
                                    clientErrors.objectives &&
                                        (clientErrors.objectives[index] =
                                            undefined)
                                "
                            />
                            <button
                                type="button"
                                @click="courseData.objectives.splice(index, 1)"
                                class="frosted-backdrop min-height-[3.75em] min-width-0 decoration-none transition-[all cubic-bezier(.23,1, 0.32,1)] user-select-none hover:shadow-[rgba(0,0,0,0.25) 0 8px 15px] border-error bg-error/10 text-error hover:text-secondary-content m-0 box-border inline-block -translate-y-0.5 cursor-pointer touch-manipulation appearance-none rounded-[0.9375em] border px-[1.5em] py-[0.25em] text-center font-bold duration-300 will-change-transform outline-none hover:bg-secondary active:translate-y-0 active:shadow-none disabled:pointer-events-none"
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
                        <InputError
                            class="input-error"
                            :message="clientErrors.objectives?.[index]"
                        />
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
                        for="users"
                        class="text-base-content mb-4 block text-sm font-medium"
                    >
                        Users</label
                    >
                    <div
                        v-for="(user, index) in courseData.users"
                        :key="user.id"
                        class="text-base-content mb-2 flex flex-col gap-2"
                    >
                        <div class="flex items-center gap-2">
                            {{ user.name }}
                            <select
                                v-model="user.role"
                                class="bg-base-200 text-base-content mt-1 block w-full border border-primary p-2"
                                @change="
                                    clientErrors.users &&
                                        (clientErrors.users[index] = undefined)
                                "
                            >
                                <option value="Designer">Designer</option>
                                <option value="SME">Subject Matter Expert</option>
                                <option value="Manager">Manager</option>
                                <option value="Builder">Builder</option>
                            </select>
                        </div>
                        <InputError
                            class="input-error"
                            :message="clientErrors.users?.[index]"
                        />
                    </div>

                    <select
                        v-if="addingUser"
                        @change="updateUsers"
                        v-model="selectedUserId"
                        id="users"
                        class="bg-base-200 text-base-content mt-1 block w-full border border-primary p-2"
                    >
                        <option
                            class="text-base-content"
                            v-for="user in users"
                            :key="user.id"
                            :value="user.id"
                        >
                            {{ user.name }}
                        </option>
                    </select>
                    <button
                        type="button"
                        @click="addUser"
                        class="min-height-[3.75em] min-width-0 decoration-none transition-[all cubic-bezier(.23,1, 0.32,1)] user-select-none hover:shadow-[rgba(0,0,0,0.25) 0 8px 15px] text-primary-content m-0 mt-4 box-border inline-block -translate-y-0.5 cursor-pointer touch-manipulation appearance-none rounded-lg bg-primary px-[1.5em] py-[0.25em] text-center font-bold duration-300 will-change-transform outline-none hover:bg-primary/30 active:translate-y-0 active:bg-primary/50 active:shadow-none disabled:pointer-events-none"
                    >
                        Add User
                    </button>
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
import { onMounted, ref, computed, nextTick } from 'vue';
import InputError from '@/components/InputError.vue'; // Will need to be added to the template
import { useToast } from '@/components/ui/toast/use-toast'; // Potentially for future use with a global notification system

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

interface ClientErrors {
    prefix?: string;
    number?: string;
    title?: string;
    development_cycle?: string;
    objectives?: string[]; // Array to hold messages for objectives, if any
    users?: string[]; // Array to hold messages for users, if any
    general?: string; // For any general form errors
}

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
const addingUser = ref(false);
const selectedUserId = ref<number | null>(null);

const clientErrors = ref<ClientErrors>({});

const validate = (): boolean => {
    clientErrors.value = {}; // Clear previous errors
    let isValid = true;

    // Validate prefix
    if (!courseData.value.prefix) {
        clientErrors.value.prefix = 'The course prefix is required.';
        isValid = false;
    } else if (courseData.value.prefix.length > 10) {
        clientErrors.value.prefix = 'The course prefix must not be greater than 10 characters.';
        isValid = false;
    }

    // Validate number
    if (!courseData.value.number) {
        clientErrors.value.number = 'The course number is required.';
        isValid = false;
    } else if (isNaN(Number(courseData.value.number))) {
        clientErrors.value.number = 'The course number must be an integer.';
        isValid = false;
    }

    // Validate title
    if (!courseData.value.title) {
        clientErrors.value.title = 'The course title is required.';
        isValid = false;
    } else if (courseData.value.title.length > 255) {
        clientErrors.value.title = 'The course title must not be greater than 255 characters.';
        isValid = false;
    }

    // Validate development_cycle (nullable, integer)
    if (courseData.value.development_cycle !== null && isNaN(Number(courseData.value.development_cycle))) {
        clientErrors.value.development_cycle = 'The development cycle must be an integer or null.';
        isValid = false;
    }

    // Validate objectives (nullable|array, then nested rules)
    if (courseData.value.objectives && courseData.value.objectives.length > 0) {
        clientErrors.value.objectives = [];
        courseData.value.objectives.forEach((obj, index) => {
            if (!obj.number) {
                clientErrors.value.objectives[index] = `Objective ${index + 1} number is required.`;
                isValid = false;
            } else if (obj.number.length > 10) {
                clientErrors.value.objectives[index] = `Objective ${index + 1} number must not be greater than 10 characters.`;
                isValid = false;
            }
            if (!obj.objective) {
                if (!clientErrors.value.objectives[index]) {
                    clientErrors.value.objectives[index] = `Objective ${index + 1} description is required.`;
                }
                isValid = false;
            } else if (obj.objective.length > 255) {
                if (!clientErrors.value.objectives[index]) {
                    clientErrors.value.objectives[index] = `Objective ${index + 1} description must not be greater than 255 characters.`;
                }
                isValid = false;
            }
        });
    }

    // Validate users (nullable|array, then nested rules)
    if (courseData.value.users && courseData.value.users.length > 0) {
        clientErrors.value.users = [];
        courseData.value.users.forEach((user, index) => {
            if (!user.id) {
                clientErrors.value.users[index] = `User ${index + 1} ID is required.`;
                isValid = false;
            }
            // Note: 'exists' validation is server-side only.
            if (!user.role) {
                if (!clientErrors.value.users[index]) {
                    clientErrors.value.users[index] = `User ${index + 1} role is required.`;
                }
                isValid = false;
            } else if (user.role.length > 50) {
                if (!clientErrors.value.users[index]) {
                    clientErrors.value.users[index] = `User ${index + 1} role must not be greater than 50 characters.`;
                }
                isValid = false;
            }
        });
    }

    return isValid;
};

const handleCreateCourse = () => {
    if (!validate()) {
        nextTick(() => {
            const firstErrorElement = document.querySelector('.input-error:not(:empty)');
            if (firstErrorElement) {
                firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        return; // Stop submission if client-side validation fails
    }

    // Emit the create-course event with the course data
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
    clientErrors.value = {}; // Clear errors after successful submission
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

const addUser = () => {
    addingUser.value = true;
    clientErrors.value.users = undefined; // Clear user-related errors when adding
};

const updateUsers = () => {
    if (selectedUserId.value) {
        const selectedUser = users.value.find(
            (user) => user.id === selectedUserId.value,
        );
        if (
            selectedUser &&
            !courseData.value.users.some(
                (user) => user.id === selectedUserId.value,
            )
        ) {
            courseData.value.users.push({ ...selectedUser, role: 'Designer' });
        }
        addingUser.value = false;
        selectedUserId.value = null;
    }
};
const createObjective = () => {
    courseData.value.objectives.push({
        number: toRoman(courseData.value.objectives.length + 1),
        objective: '',
    });
    clientErrors.value.objectives = undefined; // Clear objective-related errors when adding
};

onMounted(async () => {
    try {
        const response = await fetch('/courses/create', {
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
        });
        const data = await response.json();
        users.value = data.users;
        developmentCycles.value = data.cycles || [];
    } catch (error) {
        console.error('Failed to fetch users:', error);
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
input{
    color: var(--slate-900);
}
</style>
