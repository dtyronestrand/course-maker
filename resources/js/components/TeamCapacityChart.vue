<template>
    <div v-bind="$attrs">
        <div
            v-for="user in usersWorkloads"
            :key="user.name"
            class="shadow-base-200/20 flex items-center justify-between gap-4 rounded-lg shadow-sm"
        >
            <div class="flex justify-evenly">
                <div class="placeholder avatar">
                    <div
                        class="my-2 flex h-8 w-8 items-center rounded-full border border-olive-300 text-olive-300 shadow-sm"
                    >
                        <p class="mx-auto text-sm">
                            {{ getInitials(user.name) }}
                        </p>
                    </div>
                </div>
                <progress
                    id="capacity"
                    class="progress mx-4 w-50 place-self-center bg-olive-300"
                    :value="user.workload"
                    min="0"
                    max="100"
                ></progress>
                <p class="place-self-center text-xs">{{ user.workload }}%</p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { getInitials } from '@/composables/useInitials';
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';

defineOptions({ inheritAttrs: false });

const users = ref([]);
const capacity = ref(0);
const usersWorkloads = computed(() => {
    return users.value.map((user: any) => ({
        name: user.name,
        workload: Math.round((user.courses_count / capacity.value) * 100),
    }));
});

onMounted(async () => {
    try {
        await axios.get('/sanctum/csrf-cookie');
        const [usersResponse, capacityResponse] = await Promise.all([
            axios.get('/api/users-workloads'),
            axios.get('/api/capacity'),
        ]);
        users.value = usersResponse.data.users;
        capacity.value = capacityResponse.data.capacity;
        console.log('Capacity:', capacity.value);
    } catch (error) {
        console.error('Error fetching user workloads:', error);
    }
});
</script>

<style scoped></style>
