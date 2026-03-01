<template>
    <div v-if="visible" class="fixed top-0 left-0 mx-auto w-full h-full overflow-hidden z-[999] bg-background/50">
        <div class="fixed top-0 left-0 w-full h-full z-[1000] bg-background/50">
        <div :class="modalClass" class="relative mx-auto mt-[8rem] p-[20px] w-[80%] max-w-[500px] glass rounded-[5px] z-[1001]">
        <div class="flex justify-between align-center mb-[20px]">
        <slot name="header">
        <h3>{{ title }}</h3>
        </slot>
        <button @click="closeModal" class="bg-none border-none cursor-pointer text-[24px]">&times;</button>
        </div>
        <div class="m-[20px 0]">
        <slot name="body"></slot>
        </div>
        <div class="flex justify-end">
        <slot name="footer">
            <button class="p-[8px 16px] bg-[#4CAFF50] text-white border-none rounded-[4px] cursor-pointer hover:bg-[#45a049]"></button>
        </slot>
        </div>
        </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const props = withDefaults(defineProps<{
    title: string;
    visible: boolean;
    modalClass?: string;
}>(), {
    title: 'Modal Title',
    visible: false,
    modalClass: '',
});

const emit = defineEmits(['close']);
const closeModal = () => {
    emit('close');
}

</script>

<style scoped>

</style>