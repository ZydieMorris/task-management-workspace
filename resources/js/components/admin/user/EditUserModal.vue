<template>
    <div>
        <Dialog v-model:open="open">

            <DialogContent class="sm:max-w-[425px]">
          <form @submit.prevent="editUser()">
        <DialogHeader>
          <DialogTitle>Edit New User</DialogTitle>
          <DialogDescription>

          </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4">

          <div class="grid gap-3">
            <Label >Name</Label>
            <Input v-model="form.name" />
          </div>

          <div class="grid gap-3">
            <Label >Email</Label>
            <Input v-model="form.email" />
          </div>

            <div class="grid gap-3">
                 <Label >Password</Label>
                 <Input  v-model="form.password"/>
            </div>

            <div class="grid gap-3">
                <Label >Role</Label>
                 <Select v-model="form.role">
                    <SelectTrigger>
                    <SelectValue placeholder="Select a Role" />
                    </SelectTrigger>
                    <SelectContent >
                    <SelectItem v-for="r in roles" :key="r" :value="r">
                        {{ r }}

                    </SelectItem>
                    </SelectContent>
                </Select>
            </div>

            <div class="grid gap-3">
                <Label >Position</Label>
                 <Select v-model="form.position">
                    <SelectTrigger>
                    <SelectValue placeholder="Select a Postion" />
                    </SelectTrigger>
                    <SelectContent>
                    <SelectItem   v-for=" p in positions" :key="p.id" :value="p.position_name">
                        {{ p.position_name }}
                    </SelectItem>
                    </SelectContent>
                </Select>
            </div>

        </div>
        <DialogFooter>
          <DialogClose as-child>
            <Button variant="outline">
              Cancel
            </Button>
          </DialogClose>
          <Button type="submit" :disabled="form.processing">
            Save Changes
          </Button>
        </DialogFooter>
    </form>
      </DialogContent>
  </Dialog>
    </div>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Plus } from 'lucide-vue-next';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { User } from '@/types';
import { Position } from '@/types/usertype';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = defineProps<{
    positions: Position[],
    roles: string[],
    user: User | null,
}>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: '',
    position: '',
});

watch(() => props.user, (newUser) => {
    if (newUser) {
        form.name = newUser.name;
        form.email = newUser.email;
        form.role = newUser.role;
        form.position = newUser.position;
    }
}, { immediate: true });

function editUser(){
    form.put(`/admin/users/${props.user?.id}`,{
        onSuccess: () => {
            open.value = false;
        },
    });
}

const open = defineModel('open')

</script>


