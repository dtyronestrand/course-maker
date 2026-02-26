<template>
    <div>
        <table class="glass table-auto w-full ">
        <thead>
            <tr v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                <th v-for="header in headerGroup.headers" :key="header.id" class="px-8 py-4 text-left text-xs font-medium uppercase tracking-wder">
                  <FlexRender :render="header.column.columnDef.header" :props="header.getContext()" />
                </th>
            </tr>
        </thead>
                <tbody class=" ">
                    <tr v-for="row in table.getRowModel().rows" :key="row.id">
                        <td v-for="cell in row.getVisibleCells()" :key="cell.id" class="px-8 py-4 whitespace-nowrap">
                            <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                        </td>
                    </tr>
                </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">

import type { User } from '@/types/auth';
import { ref } from 'vue';
import {useVueTable, FlexRender, getCoreRowModel} from '@tanstack/vue-table';
const props = defineProps<{
    users: User[];
}>();
const columnsUsers = [
    {
        accessorKey: 'name',
        header: 'Name',
    },
    {
        accessorKey: 'role',
        header: 'Role',
    }
]
const data = ref(props.users);
const table = useVueTable({
    data: data.value,
    columns: columnsUsers,
    getCoreRowModel: getCoreRowModel(), 
})
</script>

<style scoped>

</style>