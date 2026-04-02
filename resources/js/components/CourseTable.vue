<template>
    <table
        class="glass mt-8 w-full border-collapse overflow-y-auto rounded-xl border border-primary p-8 shadow-lg shadow-primary"
    >
        <thead>
            <tr
                v-for="headerGroup in table.getHeaderGroups()"
                :key="headerGroup.id"
            >
                <th
                    v-for="header in headerGroup.headers"
                    :key="header.id"
                    :colSpan="header.colSpan"
                    :class="
                        header.column.getCanSort()
                            ? 'cursor-pointer select-none'
                            : ''
                    "
                    @click="header.column.getToggleSortingHandler()?.($event)"
                    scope="col"
                >
                    <template v-if="!header.isPlaceholder">
                        <FlexRender
                            :render="header.column.columnDef.header"
                            :props="header.getContext()"
                        />

                        {{
                            { asc: ' 🔼', desc: ' 🔽' }[
                                header.column.getIsSorted() as string
                            ]
                        }}
                    </template>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="row in table.getRowModel().rows"
                :key="row.id"
                class="cursor-pointer hover:bg-primary/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2"
                tabindex="0"
                @click="
                    () => {
                        selectedCourse = row.original;
                        showCourseDetailsModal = true;
                    }
                "
                @keydown.enter.prevent="
                    () => {
                        selectedCourse = row.original;
                        showCourseDetailsModal = true;
                    }
                "
                @keydown.space.prevent="
                    () => {
                        selectedCourse = row.original;
                        showCourseDetailsModal = true;
                    }
                "
            >
                <td
                    class="pl-8"
                    v-for="cell in row.getVisibleCells()"
                    :key="cell.id"
                >
                    <FlexRender
                        :render="cell.column.columnDef.cell"
                        :props="cell.getContext()"
                    />
                </td>
            </tr>
        </tbody>
    </table>
    <CourseDetals
        v-if="showCourseDetailsModal && selectedCourse"
        :isOpen="showCourseDetailsModal"
        :course="selectedCourse"
        :developmentCycles="developmentCycles"
        @modal-close="showCourseDetailsModal = false"
    />
</template>

<script setup lang="ts">
import { ref, h, computed } from 'vue';
import type { Course } from '@/types';
import CourseDetals from '@/components/courses/CourseDetails.vue';
import {
    useVueTable,
    FlexRender,
    getCoreRowModel,
    getSortedRowModel,
    getGroupedRowModel,
    getExpandedRowModel,
    type SortingState,
    type ExpandedState,
    type GroupingState,
    createColumnHelper,
} from '@tanstack/vue-table';

const props = defineProps<{
    courses: Course[];
    developmentCycles: Array<any>;
}>();
const showCourseDetailsModal = ref(false);
const selectedCourse = ref<Course | null>(null);

const data = computed(() =>
    props.courses.map((course) => {
        const transformed: Course & Record<string, any> = { ...course };
        course.users.forEach((user) => {
            if (user.pivot?.role) {
                const role = user.pivot.role;
                const name = `${user.name}`;
                transformed[role] = transformed[role]
                    ? `${transformed[role]} , ${name}`
                    : name;
            }
        });
        return transformed;
    }),
);
const grouping = ref<GroupingState>([]);
const expanded = ref<ExpandedState>({});
const sorting = ref<SortingState>([]);
const columnHelper = createColumnHelper<any>();
const allRoles = computed(() => {
    const rolesSet = new Set<string>();
    props.courses.forEach((course) => {
        course.users.forEach((user) => {
            if (user.pivot?.role) {
                rolesSet.add(user.pivot.role);
            }
        });
    });
    return Array.from(rolesSet);
});

const columnsCourses = computed(() => [
    columnHelper.group({
        header: ' Course',
        footer: (props) => props.column.id,
        columns: [
            columnHelper.accessor('prefix', {
                header: () => h('span', 'Prefix'),
                cell: (info) => info.getValue(),
                footer: (props) => props.column.id,
            }),
            columnHelper.accessor((row) => row.number, {
                id: 'number',
                cell: (info) => info.getValue(),
                header: () => h('span', 'Number'),
                enableSorting: false,
                footer: (props) => props.column.id,
            }),
            columnHelper.accessor((row) => row.title, {
                id: 'title',
                cell: (info) => info.getValue(),
                header: () => h('span', 'Title'),
                enableSorting: false,
                footer: (props) => props.column.id,
            }),
        ],
    }),
    columnHelper.group({
        header: 'Team',
        columns: allRoles.value.map((role) =>
            columnHelper.accessor(role, {
                cell: (info) => info.getValue() || '-',
                header: () => h('span', role),
                footer: (props) => props.column.id,
            }),
        ),
    }),
]);

const table = useVueTable({
    data: data.value,
    columns: columnsCourses.value,
    state: {
        get sorting() {
            return sorting.value;
        },
        get grouping() {
            return grouping.value;
        },
        get expanded() {
            return expanded.value;
        },
    },
    onSortingChange: (updaterOrValue) => {
        sorting.value =
            typeof updaterOrValue === 'function'
                ? updaterOrValue(sorting.value)
                : updaterOrValue;
    },
    onGroupingChange: (updaterOrValue) => {
        grouping.value =
            typeof updaterOrValue === 'function'
                ? updaterOrValue(grouping.value)
                : updaterOrValue;
    },
    onExpandedChange: (updaterOrValue) => {
        expanded.value =
            typeof updaterOrValue === 'function'
                ? updaterOrValue(expanded.value)
                : updaterOrValue;
    },

    getSortedRowModel: getSortedRowModel(),
    getCoreRowModel: getCoreRowModel(),
    getGroupedRowModel: getGroupedRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
});
</script>

<style scoped>
table {
    border-collapse: collapse;
}
tbody {
    border-bottom: 1px solid rgba(from var(--color-primary) R G B / 0.2);
}

th,
td {
    border-bottom: 1px solid rgba(from var(--color-primary) R G B / 0.2);
    border-right: 1px solid rgba(from var(--color-primary) R G B / 0.2);
    padding: 4px 8px;
}
th:last-child,
td:last-child {
    border-right: none;
}
tr:last-child td {
    border-bottom: 1px solid rgba(from var(--color-primary) R G B / 0.5);
}

th {
    padding: 8px;
}
</style>
