<template>
    <div>

    </div>
</template>

<script setup lang="ts">
import type { User } from '@/types/auth';
import { usePage } from '@inertiajs/vue3';
const page = usePage();
defineProps<{
    users: User[];
}>();
 
</script>

<style scoped>

</style>