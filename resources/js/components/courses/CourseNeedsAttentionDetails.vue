<template>
    <div
        class="fixed inset-0 z-50 flex w-full items-center justify-center bg-surface backdrop-blur-sm"
        @click.self="emit('modal-close')"
    >
        <div
            v-if="props.isOpen"
            role="dialog"
            aria-modal="true"
            aria-labelledby="attention-modal-title"
            class="mx-auto w-full max-w-3xl rounded-lg border border-primary bg-surface-container p-6 shadow-sm shadow-primary"
        >
            <div class="mb-4 flex items-start justify-between">
                <h2 id="attention-modal-title" class="text-2xl font-bold">
                    {{ props.course.prefix }} {{ props.course.number }}
                </h2>
                <button
                    @click="emit('modal-close')"
                    class="rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none"
                    aria-label="Close modal"
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
            <ul class="mb-4">
                <li
                    v-for="user in props.course.users"
                    :key="user.id"
                    class="text-lg"
                >
                    {{ user.name }} - {{ user.pivot?.role }}
                </li>
            </ul>
            <h3 class="mb-2 text-xl font-semibold">Past Due Deliverables</h3>
            <ul class="list-inside list-disc">
                <li
                    v-for="deliverable in props.course.deliverables"
                    :key="deliverable.id"
                >
                    <span v-if="deliverable.pivot?.missed_due_date_count != 0"
                        >{{ deliverable.name }} ({{
                            daysLate(deliverable.pivot?.due_date)
                        }}
                        days late)</span
                    >
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useDateUtils } from '@/composables/useDateUtils';
import type { Course } from '@/types';

interface Props {
    isOpen: boolean;
    course: Course;
}
const props = defineProps<Props>();
const emit = defineEmits(['modal-close']);

const { daysLate } = useDateUtils();
</script>

<style scoped></style>
