<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <h1 class="mb-4 text-2xl font-bold">Admin Settings</h1>
        </div>
        <div
            class="glass mx-8 flex flex-col p-8 md:flex-row md:flex-wrap md:justify-evenly lg:flex-row"
        >
            <div>
                <h2 class="mb-4 text-lg">Designer Capacity</h2>
                <form
                    @submit.prevent="handleSettings"
                    class="flex flex-col gap-4"
                >
                    <input
                        type="number"
                        v-model="capacity"
                        class="max-w-xs px-4 text-black"
                        @change="isDirty = true"
                    />
                    <div v-if="isDirty">
                        <Button
                            @click="handleSettings"
                            variant="success"
                            class="btn btn-primary"
                            >Save</Button
                        >
                        <Button
                            @click="
                                capacity =
                                    (
                                        page.props.settings as Record<
                                            string,
                                            any
                                        >
                                    )['Designer Capacity'] || 0;
                                isDirty = false;
                            "
                            variant="error"
                            class="ml-2"
                            >Cancel</Button
                        >
                    </div>
                </form>
            </div>
            <div>
                <h2 class="mb-4 text-lg">Development Cycles</h2>
                <div
                    v-for="cycle in page.props.developmentCycles"
                    :key="cycle.id"
                    class="mb-4"
                >
                    <div class="flex flex-row flex-nowrap justify-between">
                        <h3 class="text-md font-semibold">{{ cycle.name }}</h3>
                        <div class="flex space-x-2">
                            <Pencil
                                @click="editCycle(cycle)"
                                class="text-amber-500"
                                :size="20"
                            />
                            <Trash2
                                @click="deleteCycle(cycle)"
                                class="text-red-500"
                                :size="20"
                            />
                        </div>
                    </div>
                    <p>Start Date: {{ cycle.start_date }}</p>
                    <p>End Date: {{ cycle.end_date }}</p>
                </div>
                <Button @click="addCycle = true">Add Development Cycle</Button>
                <form
                    v-if="addCycle"
                    @submit.prevent
                    class="mt-4 flex flex-col gap-4"
                >
                    <div>
                        <label for="cycleName">Cycle Name</label>
                        <input
                            type="text"
                            v-model="cycle.name"
                            name="cycleName"
                            placeholder="Cycle Name"
                            class="mb-2 w-full max-w-xs px-4 text-black"
                        />
                    </div>
                    <div>
                        <label for="startDate">Start Date</label>
                        <input
                            type="date"
                            v-model="cycle.start_date"
                            name="startDate"
                            class="mb-2 w-full max-w-xs px-4 text-black"
                        />
                    </div>
                    <div>
                        <label for="endDate">End Date</label>
                        <input
                            type="date"
                            v-model="cycle.end_date"
                            name="endDate"
                            class="mb-2 w-full max-w-xs px-4 text-black"
                        />
                    </div>
                    <Button
                        @click="addCycle = false"
                        variant="destructive"
                        class="mr-2"
                        >Cancel</Button
                    >
                    <Button @click="saveCycle" class="btn btn-primary"
                        >Save Cycle</Button
                    >
                </form>
            </div>
            <div>
                <h2 class="mb-4 text-lg">Deliverables</h2>
                <table class="min-w-full divide-y divide-amber-500">
                    <thead>
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-start text-sm text-amber-500 uppercase"
                            >
                                Deliverable
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-start text-sm text-amber-500 uppercase"
                            >
                                Offset Days
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-start text-sm text-amber-500 uppercase"
                            ></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="deliverable in page.props.deliverables"
                            :key="deliverable.id"
                        >
                            <td class="px-6 py-4 text-sm whitespace-nowrap">
                                {{ deliverable.name }}
                            </td>
                            <td
                                class="px-6 py-4 text-center text-sm whitespace-nowrap"
                            >
                                {{ deliverable.offset_days }}
                            </td>
                            <td class="px-6 py-4 text-sm whitespace-nowrap">
                                <Trash2
                                    @click="
                                        router.delete(
                                            `/deliverables/${deliverable.id}`,
                                        )
                                    "
                                    class="text-red-500"
                                    :size="20"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Button @click="addDeliverable = true">Add Deliverable</Button>
                <form
                    v-if="addDeliverable"
                    @submit.prevent
                    class="mt-4 flex flex-col gap-4"
                >
                    <div>
                        <label for="deliverableName">Deliverable Name</label>
                        <input
                            type="text"
                            v-model="newDeliverable.name"
                            name="deliverableName"
                            placeholder="Deliverable Name"
                            class="mb-2 w-full max-w-xs px-4 text-black"
                        />
                    </div>
                    <div>
                        <label for="offsetDays">Offset Days</label>
                        <input
                            type="number"
                            v-model="newDeliverable.offset_days"
                            name="offsetDays"
                            placeholder="Offset Days"
                            class="mb-2 w-full max-w-xs px-4 text-black"
                        />
                    </div>
                    <Button
                        variant="success"
                        @click="saveDeliverable"
                        class="btn btn-primary"
                        >Save Deliverable</Button
                    >
                    <Button
                        @click="addDeliverable = false"
                        variant="error"
                        class="mr-2"
                        >Cancel</Button
                    >
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import { type BreadcrumbItem } from '@/types';
import { usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { dashboard } from '@/routes';
import type { AdminSetting, DevelopmentCycle, Deliverable } from '@/types';
import type { PageProps as InertiaPageProps } from '@inertiajs/core';
import { Pencil, Trash2 } from 'lucide-vue-next';

interface PageProps extends InertiaPageProps {
    settings: AdminSetting[];
    developmentCycles: DevelopmentCycle[];
    [key: string]: any;
    deliverables: Deliverable[];
}

const page = usePage<PageProps>();
const cycle = ref<DevelopmentCycle>({
    name: '',
    start_date: null,
    end_date: null,
} as DevelopmentCycle);

const isDirty = ref(false);
const newDeliverable = ref({
    name: '',
    offset_days: 0,
});
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Admin Settings',
        href: '#',
    },
];

const capacity = ref<AdminSetting['value']>(
    (page.props.settings as Record<string, any>)['Designer Capacity'] || 0,
);
const editCycle = (cycleData: DevelopmentCycle) => {
    cycle.value = { ...cycleData };
    addCycle.value = true;
};
const deleteCycle = (cycleData: DevelopmentCycle) => {
    router.delete(`/development_cycles/${cycleData.id}`);
};
const handleSettings = () => {
    router.post(
        '/admin_settings',
        {
            key: 'Designer Capacity',
            value: String(capacity.value),
        },
        {
            onSuccess: () => {
                console.log('Settings saved successfully');
                isDirty.value = false;
            },
            onError: (errors) => {
                console.error('Validation errors:', errors);
            },
            onFinish: () => {
                console.log('Request finished');
            },
        },
    );
};
const addCycle = ref(false);

const saveCycle = () => {
    router.post(
        '/development_cycles',
        {
            name: cycle.value?.name,
            start_date: cycle.value?.start_date,
            end_date: cycle.value?.end_date,
        },
        {
            onSuccess: () => {
                console.log('Development cycle saved successfully');
                addCycle.value = false;
                cycle.value = { name: '', start_date: null, end_date: null };
            },
            onError: (errors) => {
                console.error('Validation errors:', errors);
            },
            onFinish: () => {
                console.log('Request finished');
            },
        },
    );
};
const saveDeliverable = () => {
    router.post(
        '/deliverables',
        {
            name: newDeliverable.value.name,
            offset_days: newDeliverable.value.offset_days,
        },
        {
            onSuccess: () => {
                console.log('Deliverable saved successfully');
                addDeliverable.value = false;
                newDeliverable.value = { name: '', offset_days: 0 };
            },
            onError: (errors) => {
                console.error('Validation errors:', errors);
            },
            onFinish: () => {
                console.log('Request finished');
            },
        },
    );
};
const addDeliverable = ref(false);
</script>

<style scoped></style>
