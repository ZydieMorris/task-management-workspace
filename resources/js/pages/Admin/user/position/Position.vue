<template>
    <div class="p-10">
        <NavTabs :tabs="[
            { label: 'User', href: '/admin/users' },
            { label: 'Position', href: '/admin/positions' },
        ]" />

        <div class="flex justify-between">
            <div class="gap-2">
                <Input v-model="search" placeholder="Search positions..." class="w-70"/>
            </div>
            <AddPositionModal/>
        </div>

        <div class="mt-8">
            
            <TablePosition :positions="positions" @edit="onEdit" />

            <div>


            </div>

             <EditPositionModal v-model:open="showEdit" :position="selectedPosition" />
        </div>
    </div>
</template>

<script setup lang="ts">
import NavTabs from '@/components/NavTabs.vue';
import AddPositionModal from '@/components/admin/position/AddPositionModal.vue';
import TablePosition from '@/components/admin/position/TablePosition.vue';
import { ref, watch } from 'vue';
import { Position } from '@/types/usertype';
import EditPositionModal from '@/components/admin/position/EditPositionModal.vue';
import Input from '@/components/ui/input/Input.vue';
import { watchDebounced } from '@vueuse/core';
import {router} from '@inertiajs/vue3';

const selectedPosition = ref(null);
const showEdit = ref(false);
const search = ref('');

defineProps<{
    positions: Position[],
}>();

function onEdit(position: any){
    selectedPosition.value = position;
    showEdit.value = true;
}

watchDebounced(search, (newValue)=> {
    router.get('/admin/positions', { search: newValue }, { preserveState: true});
}, 5000);
</script>
