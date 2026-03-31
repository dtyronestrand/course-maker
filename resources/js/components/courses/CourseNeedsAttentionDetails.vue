<template>
    <div
        class="fixed inset-0 z-50 flex items-center w-full justify-center bg-slate-900/50 backdrop-blur-sm"
        @click.self="emit('modal-close')"
    >
        <div
            v-if="props.isOpen"
            class="mx-auto max-w-3xl rounded-lg p-4 shadow-sm border border-primary bg-slate-800 shadow-primary"
        >
            <h2 class="mb-4 text-2xl font-bold">
                {{ props.course.prefix }} {{ props.course.number }}
            </h2>
            <ul class="mb-4 ">
            <li v-for="user in props.course.users" :key="user.id" class="text-lg">
                {{ user.name }} - {{ user.pivot?.role }}
            </li>
            </ul>
            <h3 class="mb-2 text-xl font-semibold">Past Due Deliverables</h3>
             <ul class="list-inside list-disc">
           <li v-for="deliverable in props.course.deliverables" :key="deliverable.id">
           <span v-if="deliverable.pivot?.missed_due_date_count != 0">{{ deliverable.name }} ({{ daysLate(deliverable.pivot?.due_date) }} days late)</span>
           </li>
            
            </ul>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Course } from '@/types';

interface Props {
    isOpen: boolean;
    course: Course;
}
const props = defineProps<Props>();
const emit = defineEmits(['modal-close']);

const daysLate = (due_date: any) => {
    const dueDate = new Date(due_date);
    const today = new Date();
    const timeDiff = today.getTime() - dueDate.getTime();
    return Math.ceil(timeDiff / (1000 * 3600 * 24));
}
</script>

<style scoped></style>