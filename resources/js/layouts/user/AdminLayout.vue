<script setup lang="ts">
import { LayoutGrid, Users, Settings, User2 } from 'lucide-vue-next';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItem, NavGroup } from '@/types';


const groups: NavGroup[] = [
    {
        label: 'MAIN',
        items: [
            { title: 'Dashboard', href: '/admin/dashboard', icon: LayoutGrid },
            { title: 'Users', href: '/admin/users', icon: Users },
            { title: 'Projects', href: '/admin/projects', icon: User2 },
            { title: 'Announcement', href: '/admin/settings', icon: Settings },
        ],
    },

];
</script>

<template>
    <AppSidebarLayout  :groups="groups">
        <slot />
    </AppSidebarLayout>
</template>
