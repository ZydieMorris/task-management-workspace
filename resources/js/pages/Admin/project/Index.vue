<script setup lang="ts">
import AddProjectModal from '@/components/admin/project/AddProjectModal.vue';
import EditProjectModal from '@/components/admin/project/EditProjectModal.vue';
import TableProject from '@/components/admin/project/TableProject.vue';
import { Project } from '@/types/usertype';
import { watchDebounced } from '@vueuse/core';
import {ref} from 'vue';
import {router} from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';

const props = defineProps<{
    severity: string[],
    projects: Project[],
}>();

const showEditModal = ref(false);
const selectedProject = ref(null);
const search = ref('');

function openEditModal(project: any) {
    selectedProject.value = project;
    showEditModal.value = true;

}

watchDebounced(search,(newValue)=> {
router.get('/admin/projects', {search:newValue}, {preserveState: true});
})


</script>

<template>
    <div class="p-10">

        <div class="flex justify-between">
            <Input v-model="search" placeholder="Search projects..." class="w-70"/>

            <AddProjectModal :severity="severity"/>
        </div>

        <div class="mt-8">
         
            <TableProject :projects="projects" @edit="openEditModal"/>

            <EditProjectModal :severity="severity" :project="selectedProject" v-model:open="showEditModal"/>
        </div>
    </div>
</template>


