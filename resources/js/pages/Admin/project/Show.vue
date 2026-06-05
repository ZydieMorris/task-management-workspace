<template>
    <div class="p-10">
        <Link href="/admin/projects">
            <Button variant="none" class="flex items-center gap-2 text-muted-foreground hover:text-foreground">
                <ArrowLeft class="h-4 w-4" />
                Back to Projects
            </Button>
        </Link>

        <div class="flex items-center gap-4 mt-4">
            <h1 class="font-bold text-2xl">{{ projects.project_name }}</h1>
            <Badge :variant="severityBadgeVariant(projects.project_severity)">
                {{ projects.project_severity }}
            </Badge>
        </div>

        <div class="grid gap-6 mt-8">
            <Card>
                <CardHeader>
                    <CardTitle>Project Information</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="grid gap-6">
                        <div class="grid gap-1.5">
                            <Label>Description</Label>
                            <p class="text-sm text-muted-foreground">{{ projects.project_description }}</p>
                        </div>
                        <div class="grid gap-1.5">
                            <Label>Deployment Date</Label>
                            <p class="text-sm text-muted-foreground">{{ formatDate(projects.deployment_date) }}</p>
                        </div>
                    </div>
                </CardContent>
            </Card>


        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import { Project } from '@/types/usertype';
import Button from '@/components/ui/button/Button.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import Label from '@/components/ui/label/Label.vue';

defineProps<{
    projects: Project,
}>()

function severityBadgeVariant(severity: string): string {
    if (severity === 'High') return 'destructive'
    if (severity === 'Low') return 'secondary'
    return 'default'
}

function formatDate(dateString: string): string {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    })
}
</script>


