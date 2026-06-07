<template>
    <div class="mt-8">
        <p class="text-muted-foreground">Members content coming soon.</p>
    </div>
</template>

<script setup lang="ts">
import { Project } from '@/types/usertype';
import AdminLayout from '@/layouts/user/AdminLayout.vue';
import ProjectLayout from '@/layouts/user/ProjectLayout.vue';

defineOptions({
    layout: [AdminLayout, ProjectLayout],
})

defineProps<{
    projects: Project,
}>()
</script>
