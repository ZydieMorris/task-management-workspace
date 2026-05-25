<script setup lang="ts">
import AddProjectModal from '@/components/admin/project/AddProjectModal.vue';
import EditProjectModal from '@/components/admin/project/EditProjectModal.vue';
import TableProject from '@/components/admin/project/TableProject.vue';
import { Project } from '@/types/usertype';
import {ref} from 'vue';

const props = defineProps<{
    severity: string[],
    projects: Project[],
}>();

const showEditModal = ref(false);
const selectedProject = ref(null);


function openEditModal(project: any) {
    selectedProject.value = project;
    showEditModal.value = true;

}


</script>

<template>
    <div class="p-10">

        <div class="flex justify-end">
            <AddProjectModal :severity="severity"/>
        </div>

        <div>
            <TableProject :projects="projects" @edit="openEditModal"/>

            <EditProjectModal :severity="severity" :project="selectedProject" v-model:open="showEditModal"/>
        </div>
    </div>
</template>


