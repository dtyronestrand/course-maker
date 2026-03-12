<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <h1 class="mb-4 text-2xl font-bold">Admin Settings</h1>
            </div>
           <div class="glass flex flex-col md:justify-evenly lg:flex-row md:flex-row md:flex-wrap">
           <div class="p-8">
           <h2 class="text-lg mb-4">Designer Capacity</h2>
           <form @submit.prevent >
           <input type="number" v-model="capacity" class=" text-black px-4 max-w-xs" />
           <Button @click="handleSettings" class="btn btn-primary ml-4 mt-4">Save</Button>
           </form>
           </div>
        <div class="p-8">
        <h2 class="text-lg mb-4">Development Cycles</h2>
        <div v-for="cycle in page.props.developmentCycles" :key="cycle.id" class="mb-4">
            <h3 class="text-md font-semibold">{{ cycle.name }}</h3>
            <p>Start Date: {{ cycle.start_date }}</p>
            <p>End Date: {{ cycle.end_date }}</p>
        </div>
        <Button @click="addCycle = true">Add Development Cycle</Button>
        <form v-if="addCycle" @submit.prevent class="mt-4 flex gap-4 flex-col">
        <div>
            <label for="cycleName">Cycle Name</label>
            <input type="text" v-model="cycle.name" name="cycleName" placeholder="Cycle Name" class="text-black px-4 mb-2 w-full max-w-xs" />
        </div>
        <div>
            <label for="startDate">Start Date</label>
            <input type="date" v-model="cycle.start_date" name="startDate" class="text-black px-4 mb-2 w-full max-w-xs" />
        </div>
        <div>
            <label for="endDate">End Date</label>
            <input type="date" v-model="cycle.end_date" name="endDate" class="text-black px-4 mb-2 w-full max-w-xs" />
        </div>
            <Button @click="addCycle = false" class="btn btn-secondary mr-2">Cancel</Button>
            <Button @click="saveCycle" class="btn btn-primary">Save Cycle</Button>
        </form>
        </div>
        <div class="p-8">
        <h2 class="text-lg mb-4">Deliverables</h2>
        </div>
        </div>
         
     
    </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import { type BreadcrumbItem } from '@/types';
import {usePage, router} from '@inertiajs/vue3';
import { ref } from 'vue';
import { dashboard } from '@/routes';
import type { AdminSetting, DevelopmentCycle } from '@/types';
import type { PageProps as InertiaPageProps } from '@inertiajs/core';

interface PageProps extends InertiaPageProps {
    settings: AdminSetting[];
    developmentCycles: DevelopmentCycle[];
    [key: string]: any;
}

const page = usePage<PageProps>();
const cycle = ref({
    name: '',
    start_date: null,
    end_date: null,
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

const capacity = ref<AdminSetting['value']>((page.props.settings as Record<string, any>)['Designer Capacity'] || 0);
const handleSettings = () => {
    router.post('/admin_settings', {
        key: 'Designer Capacity',
        value: String(capacity.value)
    }, {
        onSuccess: () => {
            console.log('Settings saved successfully');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
        onFinish: () => {
            console.log('Request finished');
        }
    })
}
const addCycle = ref(false);

const saveCycle = () => {
    router.post('/development_cycles', {
        name: cycle.value.name,
        start_date: cycle.value.start_date,
        end_date: cycle.value.end_date,
    }, {
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
        }
    })
}
</script>

<style scoped></style>
