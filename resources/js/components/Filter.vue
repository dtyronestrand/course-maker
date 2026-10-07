<script lang="ts" setup>
import type { Column, Table } from '@tanstack/vue-table';
import { ListFilter } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { PropType } from 'vue';
import DebouncedInput from './DebouncedInput.vue';
const props = defineProps({
    column: {
        type: Object as PropType<Column<any, unknown>>,
        required: true,
    },
    table: {
        type: Object as PropType<Table<any>>,
        required: true,
    },
});
const firstValue = computed(() =>
    props.table.getPreFilteredRowModel().flatRows[0]?.getValue(props.column.id),
);
const columnFilterValue = computed(() => props.column.getFilterValue());
const sortedUniqueValues = computed(() =>
    typeof firstValue.value === 'number'
        ? []
        : Array.from(props.column.getFacetedUniqueValues().keys()).sort(),
);

const isOpen = ref(false);

function closeOnOutsideClick() {
    isOpen.value = false;
    document.removeEventListener('click', closeOnOutsideClick);
}

function toggleOpen() {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        setTimeout(() => document.addEventListener('click', closeOnOutsideClick));
    }
}
</script>

<template>
    <div v-if="typeof firstValue === 'number'">
        <div class="flex space-x-2">
            <DebouncedInput
                type="number"
                :min="Number(column.getFacetedMinMaxValues()?.[0] ?? '')"
                :max="Number(column.getFacetedMinMaxValues()?.[1] ?? '')"
                :modelValue="(columnFilterValue as [number, number])?.[0] ?? ''"
                @update:modelValue="
                    (value: number) =>
                        column.setFilterValue((old: [number, number]) => [
                            value,
                            old?.[1],
                        ])
                "
                :placeholder="`Min ${
                    column.getFacetedMinMaxValues()?.[0]
                        ? `(${column.getFacetedMinMaxValues()?.[0]})`
                        : ''
                }`"
                class="w-24 rounded border shadow"
            />
            <DebouncedInput
                type="number"
                :min="Number(column.getFacetedMinMaxValues()?.[0] ?? '')"
                :max="Number(column.getFacetedMinMaxValues()?.[1] ?? '')"
                :modelValue="(columnFilterValue as [number, number])?.[1] ?? ''"
                @update:modelValue="
                    (value: number) =>
                        column.setFilterValue((old: [number, number]) => [
                            old?.[0],
                            value,
                        ])
                "
                :placeholder="`Max ${
                    column.getFacetedMinMaxValues()?.[1]
                        ? `(${column.getFacetedMinMaxValues()?.[1]})`
                        : ''
                }`"
                class="w-24 rounded border shadow"
            />
        </div>
        <div class="h-1" />
    </div>
    <div v-else>
        <div class="relative">
            <button
                @click.stop="toggleOpen"
                class="rounded p-1 hover:bg-white/10"
            >
                <ListFilter class="h-4 text-primary" />
            </button>
            <div
                v-if="isOpen"
                @click.stop
                class="absolute left-0 top-full z-50 mt-1 min-w-[160px] rounded border border-primary bg-slate-800 p-2 shadow-lg"
            >
                <select
                    class="w-full border !border-primary px-2 py-1 text-sm"
                    :value="(columnFilterValue ?? '') as string"
                    @change="
                        column.setFilterValue(
                            ($event.target as HTMLSelectElement).value,
                        )
                    "
                >
                    <option value="">All</option>
                    <option
                        v-for="value in sortedUniqueValues.slice(0, 5000)"
                        :key="value"
                        :value="value"
                    >
                        {{ value }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>
