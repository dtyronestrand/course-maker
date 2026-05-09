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
                        class="my-2 flex h-8 w-8 items-center rounded-full border border-foreground shadow-sm"
                    >
                        <p class="mx-auto text-sm">
                            {{ getInitials(user.name) }}
                        </p>
                    </div>
                </div>

                <progress
                    id="capacity"
                    class="mx-4 w-50 place-self-center overflow-hidden bg-green-500"
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
import { useHttp } from '@inertiajs/vue3';
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

const http = useHttp();

onMounted(async () => {
    try {
        const [usersData, capacityData] = await Promise.all([
            http.get('/api/users-workloads'),
            http.get('/api/capacity'),
        ]);
        users.value = usersData.users;
        capacity.value = capacityData.capacity;
    } catch (error) {
        console.error('Error fetching user workloads:', error);
    }
});
</script>

<style scoped>
progress {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border: none;
    width: 250px;
    height: 20px;
    background-color: #eeeeee; /* Unfilled: Firefox */
}

progress::-webkit-progress-bar {
    background-color: #eeeeee;
    border: solid 1px var(--on-surface);
}
</style>
