<template>
    <div
        v-if="visible"
        class="fixed top-0 left-0 z-[999] mx-auto h-full w-full overflow-hidden bg-background/50"
    >
        <div class="fixed top-0 left-0 z-[1000] h-full w-full bg-background/50">
            <div
                :class="modalClass"
                class="glass relative z-[1001] mx-auto mt-[8rem] w-[80%] max-w-[500px] rounded-[5px] p-[20px]"
            >
                <div class="align-center mb-[20px] flex justify-between">
                    <slot name="header">
                        <h3>{{ title }}</h3>
                    </slot>
                    <button
                        @click="closeModal"
                        class="cursor-pointer border-none bg-none text-[24px]"
                    >
                        &times;
                    </button>
                </div>
                <div class="m-[20px 0]">
                    <slot name="body"></slot>
                </div>
                <div class="flex justify-end">
                    <slot name="footer">
                        <button
                            class="p-[8px 16px] cursor-pointer rounded-[4px] border-none bg-[#4CAFF50] text-white hover:bg-[#45a049]"
                        ></button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const props = withDefaults(
    defineProps<{
        title: string;
        visible: boolean;
        modalClass?: string;
    }>(),
    {
        title: 'Modal Title',
        visible: false,
        modalClass: '',
    },
);

const emit = defineEmits(['close']);
const closeModal = () => {
    emit('close');
};
</script>

<style scoped></style>
