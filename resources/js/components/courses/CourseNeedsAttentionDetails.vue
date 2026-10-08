<template>
    <div
        class="fixed inset-0 z-50 flex w-full items-center justify-center bg-surface backdrop-blur-sm"
        @click.self="emit('modal-close')"
    >
        <div
            v-if="props.isOpen"
            class="mx-auto max-w-3xl rounded-lg border border-primary bg-surface-container p-6 shadow-sm shadow-primary relative"
            role="dialog"
            aria-modal="true"
            aria-labelledby="attention-modal-title"
        >
            <button
                @click="emit('modal-close')"
                class="absolute right-4 top-4 text-base-content/70 hover:text-error focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 outline-none rounded-sm transition-colors"
                aria-label="Close modal"
            >
                <svg
                    class="h-6 w-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    ></path>
                </svg>
            </button>
            <h2 id="attention-modal-title" class="mb-4 text-2xl font-bold pr-8">
                {{ props.course.prefix }} {{ props.course.number }}
            </h2>
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
