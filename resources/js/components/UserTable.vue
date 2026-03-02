<template>
    <div>
        <table class="text-md mb-4 w-full rounded shadow-md">
            <thead>
                <tr
                    class="border-b"
                    v-for="headerGroup in table.getHeaderGroups()"
                    :key="headerGroup.id"
                >
                    <th
                        @click="
                            header.column.getToggleSortingHandler()?.($event)
                        "
                        v-for="header in headerGroup.headers"
                        :key="header.id"
                        scope="col"
                        class="p-3 px-5 text-left uppercase"
                    >
                        <FlexRender
                            :render="header.column.columnDef.header"
                            :props="header.getContext()"
                        />
                    </th>
                </tr>
            </thead>
            <tbody class="glass">
                <tr
                    v-for="row in table.getRowModel().rows"
                    :key="row.id"
                    class="group border-b hover:bg-slate-300 hover:text-slate-900"
                >
               
                    <td
                        v-for="cell in row.getVisibleCells()"
                        :key="cell.id"
                        class="px-5 py-3 whitespace-nowrap"
                    >
                        <FlexRender
                            :render="cell.column.columnDef.cell"
                            :props="cell.getContext()"
                        />
                    </td>
                
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import type { User } from '@/types/auth';
import { ref } from 'vue';
import {Pencil} from 'lucide-vue-next';
import {
    useVueTable,
    FlexRender,
    getCoreRowModel,
    getSortedRowModel,
    type SortingState,
    SortingFn,
} from '@tanstack/vue-table';
const props = defineProps<{
    users: User[];
}>();
const sortTeamsFn: SortingFn<User> = (rowA, rowB, _columnId) => {
    const teamA = rowA.original.current_team
        ? rowA.original.current_team.name
        : '';
    const teamB = rowB.original.current_team
        ? rowB.original.current_team.name
        : '';
    return teamA.localeCompare(teamB);
};
const columnsUsers = [
    {
        accessorKey: 'name',
        header: 'Name',
    },
    {
        accessorKey: 'role',
        header: 'Role',
    },
    {
        accessorKey: 'current_team',
        header: 'Current Team',
        cell: ({ row }: any) => {
            return row.original.current_team
                ? row.original.current_team.name
                : 'N/A';
        },
        sortingFn: sortTeamsFn,
    },
];

const sorting = ref<SortingState>([]);

const data = ref(props.users);
const table = useVueTable({
    data: data.value,
    columns: columnsUsers,
    getCoreRowModel: getCoreRowModel(),
    getSortedRowModel: getSortedRowModel(),
    state: {
        get sorting() {
            return sorting.value;
        },
    },
    onSortingChange: (updaterOrValue) => {
        sorting.value =
            typeof updaterOrValue === 'function'
                ? updaterOrValue(sorting.value)
                : updaterOrValue;
    },
});
</script>

<style scoped></style>
