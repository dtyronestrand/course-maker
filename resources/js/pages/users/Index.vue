<template>
    <Head title="Users" />
    <div>
        <h1 v-if="page.props.user_role === 'lead'">Team</h1>
        <h1 v-else>Users</h1>
        
    </div>
</template>

<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';

const page = usePage();


</script>

<style scoped>

</style>