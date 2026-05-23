<script setup lang="ts">
import { LayoutGrid, Users, Settings, User2 } from 'lucide-vue-next';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItem, NavGroup } from '@/types';

const { breadcrumbs = [] } = defineProps<{
    breadcrumbs?: BreadcrumbItem[];
}>();

const groups: NavGroup[] = [
    {
        label: 'MAIN',
        items: [
            { title: 'Dashboard', href: '/admin/dashboard', icon: LayoutGrid },
            { title: 'Users', href: '/admin/users', icon: Users },
            { title: 'Projects', href: '/admin/positions', icon: User2 },
            { title: 'Announcement', href: '/admin/settings', icon: Settings },
        ],
    },

];
</script>

<template>
    <AppSidebarLayout :breadcrumbs="breadcrumbs" :groups="groups">
        <slot />
    </AppSidebarLayout>
</template>
