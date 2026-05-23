<template>
    <div class="p-10">
        <NavTabs :tabs="[
            { label: 'User', href: '/admin/users' },
            { label: 'Position', href: '/admin/positions' },
        ]" />

        <div class="flex justify-end">
            <AddUserModal :positions="positions" :roles="roles"/>
        </div>

        <div>
            <TableUser :users="users" @edit="onEdit"/>

            <EditUserModal  v-model:open="showEdit" :user="selectedUser" :positions="positions" :roles="roles"/>
        </div>
    </div>
</template>

<script setup lang="ts">
import NavTabs from '@/components/NavTabs.vue';
import AddUserModal from '@/components/admin/user/AddUserModal.vue';
import TableUser from '@/components/admin/user/TableUser.vue';
import { Position} from '@/types/usertype';
import { User } from '@/types';
import { ref } from 'vue';
import EditUserModal from '@/components/admin/user/EditUserModal.vue';

const props = defineProps<{
    positions: Position[],
    roles: string[],
    users: User[],
}>();

const showEdit = ref(false);
const selectedUser = ref(null);

function onEdit(user: any){
    selectedUser.value = user;
    showEdit.value = true;
}

</script>
