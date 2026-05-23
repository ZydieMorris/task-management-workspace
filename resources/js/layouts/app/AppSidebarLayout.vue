<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import { Toaster } from '@/components/ui/sonner';
import type { BreadcrumbItem, NavGroup } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
    groups?: NavGroup[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    groups: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar :groups="groups" />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
        <Toaster />
    </AppShell>
</template>
