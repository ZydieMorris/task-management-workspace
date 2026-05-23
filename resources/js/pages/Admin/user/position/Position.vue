<template>
    <div class="p-10">
        <NavTabs :tabs="[
            { label: 'User', href: '/admin/users' },
            { label: 'Position', href: '/admin/positions' },
        ]" />

        <div class="flex justify-end">
            <AddPositionModal/>
        </div>

        <div class="mt-10">
            <TablePosition :positions="positions" @edit="onEdit" />

             <EditPositionModal v-model:open="showEdit" :position="selectedPosition" />
        </div>
    </div>
</template>

<script setup lang="ts">
import NavTabs from '@/components/NavTabs.vue';
import AddPositionModal from '@/components/admin/position/AddPositionModal.vue';
import TablePosition from '@/components/admin/position/TablePosition.vue';
import { ref } from 'vue';
import { Position } from '@/types/usertype';
import EditPositionModal from '@/components/admin/position/EditPositionModal.vue';


const selectedPosition = ref(null);
const showEdit = ref(false);

defineProps<{
    positions: Position[],
}>();

function onEdit(position: any){
    selectedPosition.value = position;
    showEdit.value = true;
}
</script>
