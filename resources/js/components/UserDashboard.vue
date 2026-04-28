<template>
    <div>
    <header>
    <h1 class="mb-4 text-2xl font-bold">Welcome {{ props.user.name }}</h1>
    <p>You have {{ props.courses.length }} active courses.</p>
    </header>
    <div class="grid grid-cols-4">
    <div class="col-span-3 flex gap-4 flex-row flex-wrap border border-secondary! p-4">
    <div v-for="course in props.courses" :key="course.id" class="border border-primary! w-[30%] p-4 rounded-lg glass">
    <header>
    <h2 class="text-lg font-bold">{{ course.prefix }} {{ course.number }} -- {{ userRole(course).toUpperCase() }}</h2>
    <p v-if="id(course) != user.name">Id: {{ id(course) }}</p>
    <p v-if="builder(course) != user.name">Builder: {{ builder(course) }}</p>
    <p>SME: {{ sme(course) }}</p>
    </header>
    <div class="mt-4">
    <ul>
    <li class="px-4" v-for="deliverable in course.deliverables" :key="deliverable.id"><div class="flex flex-row align-items justify-between">{{ deliverable.name}}<input type="checkbox" v-model="deliverable.pivot.id_done"/></div></li>
    </ul>
    </div>
    </div>
    </div>
    </div>

 
    </div>
</template>

<script setup lang="ts">
import type { Course, User } from '@/types';

 interface Props {
        courses: Course[];
        user: User;
    }
    const props = defineProps<Props>();
    const sme = (course: Course) => {
        
        const sme = course.users.find((u) => u.pivot?.role === 'sme');
        return sme ? sme.name : 'N/A';
    };
    const builder = (course: Course) => {
        const builder = course.users.find((u) => u.pivot?.role === 'builder');
        return builder ? builder.name : 'N/A';
    };
    const id = (course: Course) => {
        const id = course.users.find((u) => u.pivot?.role === 'designer');
        return id ? id.name : 'N/A';
    }
    const userRole = (course: Course) => {
        const user = course.users.find(u => u.id === props.user.id);
        return user?.pivot?.role ?? 'N/A';
    }
</script>
   
<style scoped></style>
