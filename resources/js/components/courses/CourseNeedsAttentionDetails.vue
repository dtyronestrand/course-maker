<template>
    <div
        class="bg-surface fixed inset-0 z-50 flex w-full items-center justify-center backdrop-blur-sm"
        @click.self="emit('modal-close')"
    >
        <div
            v-if="props.isOpen"
            class="bg-surface-container relative mx-auto max-w-3xl rounded-lg border border-primary p-4 shadow-sm shadow-primary"
        >
            <button
                @click="emit('modal-close')"
                class="absolute top-4 right-4 rounded-full p-1 hover:bg-primary/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
                aria-label="Close modal"
            >
                <X class="h-5 w-5" />
            </button>
            <h2 class="mb-4 pr-8 text-2xl font-bold">
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
import { X } from 'lucide-vue-next';
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
