<template>
    <div class="p-10">
        <NavTabs :tabs="[
            { label: 'User', href: '/admin/users' },
            { label: 'Position', href: '/admin/positions' },
        ]" />

        <div class="flex justify-between items-center mt-6">
            <div class="flex items-center gap-4">

                <!-- Search Filter -->
                <Input v-model="search" placeholder="Search users..." class="w-70"/>

                 <Select v-model="position">
                    <SelectTrigger>
                    <SelectValue placeholder="Select a Position" />
                    </SelectTrigger>
                    <SelectContent>
                    <SelectItem value="all">All Positions</SelectItem>
                    <SelectItem v-for="p in positions" :key="p.id" :value="p.position_name">
                        {{ p.position_name }}
                    </SelectItem>
                    </SelectContent>
                </Select>

                  <Select v-model="role">
                    <SelectTrigger>
                    <SelectValue placeholder="Select a Role" />
                    </SelectTrigger>
                    <SelectContent>
                    <SelectItem value="all">All Roles</SelectItem>
                    <SelectItem v-for="r in roles" :key="r" :value="r">
                        {{ r }}
                    </SelectItem>
                    </SelectContent>
                </Select>
                    
            </div>

            <div>
                <AddUserModal :positions="positions" :roles="roles"/>
            </div>
        </div>

        <div class="mt-8">
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
import {router} from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';
import { watchDebounced } from '@vueuse/core';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'

const props = defineProps<{
    positions: Position[],
    roles: string[],
    users: User[],
}>();

const showEdit = ref(false);
const selectedUser = ref(null);
const search = ref('');
const position = ref('');
const role = ref('');

function onEdit(user: any){
    selectedUser.value = user;
    showEdit.value = true;
}

watchDebounced([search, position, role],([newValue, newPosition, newRole]) => {
    router.get('/admin/users', {
        search:newValue,
        position: newPosition === 'all' ? null : newPosition,
        role: newRole === 'all' ? null : newRole 
        }, 
        {
        preserveState: true
        });
}, 500);

</script>
