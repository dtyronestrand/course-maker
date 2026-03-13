<template>
    <div>

    </div>
</template>

<script setup lang="ts">
import { ref, h, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import type {Course} from '@/types';
import {
    useVueTable,
    FlexRender,
    getCoreRowModel,
    getSortedRowModel,
    type SortingState,
    type SortingFn,
    createColumn,
    createColumnHelper
} from '@tanstack/vue-table';

const props = defineProps<{
    courses: Course[];
    developmentCycles: Array<any>;
}>();

const data = computed(() => props.courses.map((course)=>{
    const transformed: Course & Record<string, any> = {...course};
    course.users.forEach((user)=>{
        if (user.pivot?.role) {
            const role = user.pivot.role;
            const name = user.name;
            transformed[role] = transformed[role] ? `${transformed[role]} , ${name}` : name;
        }
    })
    return transformed;
}))
const sorting = ref<SortingState>([]);
const columnHelper = createColumnHelper<Course & Record<string, any>>();
const allRoles = computed(() => {
    const rolesSet = new Set<string>();
    props.courses.forEach(course => {
        course.users.forEach(user => rolesSet.add(user.pivot.role));
    });
    return Array.from(rolesSet);
});

const columnsCourses = computed(()=>[
    {
        accessorKey: 'prefix',
        header: 'Prefix',
    },
    {
        accessorKey: 'number',
        header: 'Number',
    },
    {
        accessorKey: 'name',
        header: 'Name',
    },
    columnHelper.group({
        header: 'Team',
        columns: allRoles.value.map((role) =>
            columnHelper.accessor(role, {
                cell: (info) => info.getValue() || '-',
                header: () => h('span', role),
            }))
    })

])
</script>

<style scoped>

</style>