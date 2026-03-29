<template>
    <div class="overflow-x-auto">
        <table class="text-md mb-4 w-full border-collapse rounded shadow-md">
            <thead>
                <tr
                    v-for="headerGroup in table.getHeaderGroups()"
                    :key="headerGroup.id"
                    class="border-b"
                >
                    <th
                        v-for="header in headerGroup.headers"
                        :key="header.id"
                        scope="col"
                        class="cursor-pointer p-3 px-5 text-left text-sm font-semibold uppercase select-none"
                        @click="
                            header.column.getToggleSortingHandler()?.($event)
                        "
                    >
                        <div class="flex items-center gap-2">
                            <FlexRender
                                :render="header.column.columnDef.header"
                                :props="header.getContext()"
                            />
                            <span v-if="header.column.getIsSorted() === 'asc'"
                                >🔼</span
                            >
                            <span
                                v-else-if="
                                    header.column.getIsSorted() === 'desc'
                                "
                                >🔽</span
                            >
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="row in table.getRowModel().rows"
                    :key="row.id"
                    class="group border-b transition-colors hover:bg-slate-300 hover:text-slate-900"
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
import { ref, h, computed, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import {
    useVueTable,
    FlexRender,
    getCoreRowModel,
    getSortedRowModel,
    type SortingState,
    type SortingFn,
} from '@tanstack/vue-table';
import type { Team } from '@/types/global';
import type { Course } from '@/types';
const props = defineProps<{
    users: User[];
    teams: Team[];
}>();

// --- STATE ---
const data = ref([...props.users]); // Local copy of users for reactivity
const sorting = ref<SortingState>([]);

// Sync local data when prop changes (e.g., after delete)
watch(
    () => props.users,
    () => {
        data.value = [...props.users];
    },
    { deep: true },
);
const isEditing = ref(false);
const selectedUserId = ref<number | null>(null);

// This holds the temporary values while the user is changing selects
const editBuffer = ref({
    role: '',
    team_id: null as number | null,
});

// Mock Team Data (Replace with your API fetch)
const teams = computed(() => props.teams);

const roles = ['lead', 'id', 'sme'];

// --- ACTIONS ---
const startEdit = (user: User) => {
    selectedUserId.value = user.id;
    editBuffer.value = {
        role: (user.role as string) || '',
        team_id: user.current_team?.id || null,
    };
    isEditing.value = true;
};

const cancelEdit = () => {
    isEditing.value = false;
    selectedUserId.value = null;
};

const saveEdit = async (userId: number) => {
    // 1. Perform Backend API Call here (e.g., axios.put)
    // 2. Update local state on success:
    const index = data.value.findIndex((u) => u.id === userId);
    if (index !== -1) {
        const updatedTeam = teams.value.find(
            (t) => t.id === editBuffer.value.team_id,
        );
        data.value[index] = {
            ...data.value[index],
            role: editBuffer.value.role,
            current_team: updatedTeam || null,
        };
    }
    cancelEdit();
};

const deleteUser = (userId: number) => {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(`/users/${userId}`, {
            onSuccess: () => router.reload({ only: ['users'] }),
        });
    }
};

// --- TABLE LOGIC ---
const sortTeamsFn: SortingFn<User> = (rowA, rowB) => {
    const teamA = rowA.original.current_team?.name || '';
    const teamB = rowB.original.current_team?.name || '';
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
        cell: ({ row }: any) => {
            if (isEditing.value && selectedUserId.value === row.original.id) {
                return h(
                    'select',
                    {
                        value: editBuffer.value.role,
                        onChange: (e: any) =>
                            (editBuffer.value.role = e.target.value),
                        class: 'w-full rounded border border-amber-500 p-1 text-sm bg-slate-300 text-slate-900',
                    },
                    roles.map((role) => h('option', { value: role }, role)),
                );
            }
            return row.original.role.toUpperCase();
        },
    },
    {
        accessorKey: 'current_team',
        header: 'Current Team',
        sortingFn: sortTeamsFn,
        cell: ({ row }: any) => {
            if (isEditing.value && selectedUserId.value === row.original.id) {
                return h(
                    'select',
                    {
                        value: editBuffer.value.team_id || '',
                        onChange: (e: any) =>
                            (editBuffer.value.team_id = Number(e.target.value)),
                        class: 'w-full rounded border border-gray-300 p-1 text-sm bg-white text-slate-900',
                    },
                    [
                        h('option', { value: '' }, 'N/A'),
                        ...teams.value.map((team) =>
                            h('option', { value: team.id }, team.name),
                        ),
                    ],
                );
            }
            return row.original.current_team?.name || 'N/A';
        },
    },
    {
        accessorKey: 'courses',
        header: 'Courses',
        cell: ({ row }: any) => {
            const courses = row.original.courses as Course[];
            return courses.length > 0
                ? courses.map((c) => c.prefix + ' ' + c.number).join(', ')
                : 'No courses';
        },
    },
    {
        accessorKey: 'actions',
        header: '',
        cell: ({ row }: any) => {
            const user = row.original as User;
            const isThisRowEditing =
                isEditing.value && selectedUserId.value === user.id;

            if (isThisRowEditing) {
                return h('div', { class: 'flex gap-2 items-center' }, [
                    h(
                        'button',
                        {
                            class: 'rounded bg-green-500 px-3 py-1 text-xs text-white hover:bg-green-600',
                            onClick: (e: Event) => {
                                e.stopPropagation();
                                saveEdit(user.id);
                            },
                        },
                        'Save',
                    ),
                    h(
                        'button',
                        {
                            class: 'rounded bg-red-500 px-3 py-1 text-xs text-white hover:bg-red-600',
                            onClick: (e: Event) => {
                                e.stopPropagation();
                                cancelEdit();
                            },
                        },
                        'Cancel',
                    ),
                    h(Trash2, {
                        class: 'w-4 h-4 text-red-500 cursor-pointer hover:text-red-700 ml-1',
                        role: 'button',
                        tabindex: 0,
                        'aria-label': 'Delete user',
                        onClick: (e: Event) => {
                            e.stopPropagation();
                            deleteUser(user.id);
                        },
                        onKeydown: (e: KeyboardEvent) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                                e.stopPropagation();
                                e.preventDefault();
                                deleteUser(user.id);
                            }
                        },
                    }),
                ]);
            } else {
                return h('div', { class: 'flex gap-3 items-center' }, [
                    h(Pencil, {
                        class: 'w-6 h-6 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-amber-500 hover:text-amber-700',
                        role: 'button',
                        tabindex: 0,
                        'aria-label': 'Edit user',
                        onClick: (e: Event) => {
                            e.stopPropagation();
                            startEdit(user);
                        },
                        onKeydown: (e: KeyboardEvent) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                                e.stopPropagation();
                                e.preventDefault();
                                startEdit(user);
                            }
                        },
                    }),
                ]);
            }
        },
    },
];

const table = useVueTable({
    data: data.value, // Crucial for reactivity
    columns: columnsUsers,
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
    getCoreRowModel: getCoreRowModel(),
    getSortedRowModel: getSortedRowModel(),
});
</script>

<style scoped></style>
