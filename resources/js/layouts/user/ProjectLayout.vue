<script setup lang="ts">
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { ArrowLeft } from 'lucide-vue-next'
import { Project } from '@/types/usertype'
import Button from '@/components/ui/button/Button.vue'
import Badge from '@/components/ui/badge/Badge.vue'
import NavTabs from '@/components/NavTabs.vue'

const page = usePage()
const projects = computed<Project>(() => page.props.projects as Project)

const projectTabs = computed(() => [
    { label: 'Overview', href: `/admin/projects/${projects.value.id}`, exact: true },
    { label: 'Tasks', href: `/admin/projects/${projects.value.id}/tasks` },
    { label: 'Members', href: `/admin/projects/${projects.value.id}/members` },
])

function severityBadgeVariant(severity: string): string {
    if (severity === 'High') return 'destructive'
    if (severity === 'Low') return 'secondary'
    return 'default'
}
</script>

<template>
    <div class="">
        <Link href="/admin/projects">
            <Button variant="none" class="flex items-center ml-4 gap-2 text-muted-foreground hover:text-foreground">
                <ArrowLeft class="h-4 w-4" />
                Back
            </Button>
        </Link>

        <div class="flex items-center gap-4 mt-4 ml-4">
            <h1 class="font-bold text-2xl">{{ projects.project_name }}</h1>
            <Badge :variant="severityBadgeVariant(projects.project_severity)">
                {{ projects.project_severity }}
            </Badge>
        </div>

        <NavTabs :tabs="projectTabs" />

        <div class="w-full border bg-gray-400"></div>


        <slot />
    </div>
</template>
