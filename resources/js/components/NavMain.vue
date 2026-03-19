<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    SidebarMenuSubItem,
    SidebarMenuSub,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { type NavItem } from '@/types';
import {
    Collapsible,
    CollapsibleTrigger,
    CollapsibleContent,
} from './ui/collapsible';
import SidebarMenuSubButton from './ui/sidebar/SidebarMenuSubButton.vue';
import { Plus, Minus } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    items: NavItem[];
}>();

const itemsWithFlag = computed(() =>
    props.items.map((item) => ({
        ...item,
        hasSubMenu: !!item.items?.length,
    })),
);

const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <SidebarMenu>
        <template v-for="(item, index) in itemsWithFlag" :key="item.title">
            <Collapsible
                v-if="item.hasSubMenu"
                :default-closed="index === 1"
                class="group/collapsible"
            >
                <SidebarMenuItem>
                    <CollapsibleTrigger as-child>
                        <SidebarMenuButton>
                            <component :is="item.icon" />
                            {{ item.title }}
                            <Plus
                                class="ml-auto group-data-[state=open]/collapsible:hidden"
                            />
                            <Minus
                                class="ml-auto group-data-[state=closed]/collapsible:hidden"
                            />
                        </SidebarMenuButton>
                    </CollapsibleTrigger>
                    <CollapsibleContent>
                        <SidebarMenuSub>
                            <SidebarMenuSubItem
                                v-for="childItem in item.items"
                                :key="childItem.title"
                            >
                                <SidebarMenuSubButton
                                    as-child
                                    :is-active="childItem.isActive"
                                >
                                    <Link :href="childItem.href">
                                        <component :is="childItem.icon" />
                                        <span>{{ childItem.title }}</span>
                                    </Link>
                                </SidebarMenuSubButton>
                            </SidebarMenuSubItem>
                        </SidebarMenuSub>
                    </CollapsibleContent>
                </SidebarMenuItem>
            </Collapsible>

            <SidebarMenuItem v-else>
                <SidebarMenuButton :is-active="isCurrentUrl(item.href)">
                    <component :size="16" :is="item.icon" />
                    <Link :href="item.href">
                        {{ item.title }}
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </template>
    </SidebarMenu>
</template>
