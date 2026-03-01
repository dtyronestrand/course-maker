<script setup lang="ts">
import { computed } from 'vue';
import {cn} from '@/lib/utils';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import type { User } from '@/types';
import {avatarVariants, fallbackVariants, roleVariants} from './index';
import type {AvatarVariants, FallbackVariants, RoleVariants} from './index';
type Props = {
    user: User;
    user_role?: string;
    showEmail?: boolean;
    avatar?: AvatarVariants['avatar'];
    fallback?: FallbackVariants['fallback'];
    role?: RoleVariants['role'];
};

const props = withDefaults(defineProps<Props>(), {
    showEmail: false,
});

const { getInitials } = useInitials();

// Compute whether we should show the avatar image
const showAvatar = computed(
    () => props.user.avatar && props.user.avatar !== '',
);
</script>

<template>
    <div class="flex flex-col flex-wrapitems-center gap-4">
    <div class="flex justify-center">
    <Avatar :class="cn(avatarVariants({ avatar }))">
        <AvatarImage v-if="showAvatar" :src="user.avatar!" :alt="user.name" />
        <AvatarFallback :class="cn(fallbackVariants({ fallback }))">
            {{ getInitials(user.name) }}
        </AvatarFallback>
    </Avatar>
    </div>

    <div class="flex flex-col flex-wrap flex-1 justify-between text-left text-sm leading-tight">
        <span class="text-center text-lg text-white pt-2">{{ user.name }} </span> <span :class="cn(roleVariants({ role }))">{{ user_role }}</span>
        <span v-if="showEmail" class=" text-xs text-muted-foreground">{{
            user.email
        }}</span>
    </div>
    </div>
</template>
