<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    User,
    Users,
    Cog,
    LayoutGrid,
} from 'lucide-vue-next';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuSub,
    SidebarRail,
    SidebarGroup,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import AppLogo from './AppLogo.vue';
import { dashboard } from '@/routes';
import adminsettings from '@/routes/adminsettings';
import { index, teams } from '@/routes/users';
import courses from '@/routes/courses';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'People',
        href: index(),
        icon: User,
        items: [
            {
                title: 'Teams',
                href: teams(),
                icon: Users,
            },
            {
                title: 'Users',
                href: index(),
                icon: User,
            },
        ],
    },
    {
        title: 'Courses',
        href: courses.index(),
        icon: BookOpen,
    },
    {
        title: 'Settings',
        href: adminsettings.index(),
        icon: Cog,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <SidebarGroup>
                <NavMain :items="mainNavItems" />
            </SidebarGroup>
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
        <SidebarRail />
    </Sidebar>
    <slot />
</template>
