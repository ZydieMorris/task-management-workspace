<template>
    <div>
        <Dialog>
            <DialogTrigger as-child>
                <Button class="text-xs w-auto h-7">
                    <Plus/> Add Task
                </Button>
            </DialogTrigger>
            <DialogContent class="sm:max-w-[425px]">
          <form @submit.prevent="addTask">
        <DialogHeader>
          <DialogTitle></DialogTitle>
          <DialogDescription>
          </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4">
            <!-- task name -->
          <div class="grid gap-3">
            <Label >Task Name</Label>
            <Input v-model="form.task_name" placeholder="e.g "/>
          </div>
          <div class="grid gap-3">
            <Label >Description</Label>
            <Textarea key="" placeholder="add notes.." />
          </div>

          <!-- task status -->
          <div class="grid gap-3">
            <Label >Status</Label>
            <Select v-model="form.task_status">
                <SelectTrigger class="w-[180px]">
                <SelectValue placeholder="Select a status" />
                </SelectTrigger>
                <SelectContent>
                <SelectGroup>
                    <SelectLabel></SelectLabel>
                    <SelectItem v-for="s in statuses" :key="s" :value="s">
                        {{ s }}
                    </SelectItem>
                </SelectGroup>
                </SelectContent>
            </Select>
          </div>

            <!-- task priority -->
             <div class="grid gap-3">
            <Label >Priority</Label>
            <Select v-model="form.task_priority">
                <SelectTrigger class="w-[180px]">
                <SelectValue placeholder="Select a priority" />
                </SelectTrigger>
                <SelectContent>
                <SelectGroup>
                    <SelectLabel></SelectLabel>
                    <SelectItem v-for="p in priorities" :key="p" :value="p">
                        {{ p }}

                    </SelectItem>
                </SelectGroup>
                </SelectContent>
            </Select>
          </div>

           <!-- task deadline -->
             <div class="grid gap-3">
            <Label >Deadline</Label>
            <Input type="date" v-model="form.task_deadline"/>
          </div>

          <!-- Assign to -->
        <div class="grid gap-3">
            <Label >Assign To</Label>
            <Select v-model="form.assign_to">
                <SelectTrigger class="w-[180px]">
                <SelectValue placeholder="Select a user" />
                </SelectTrigger>
                <SelectContent>
                <SelectGroup>
                    <SelectLabel></SelectLabel>
                    <SelectItem v-for="u in users" :key="u.id" :value="u.id">
                        {{ u.name }}

                    </SelectItem>
                </SelectGroup>
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
          <Button type="submit">
            Save changes
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
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { TaskStatus } from '@/types/task';
import { TaskPriority } from '@/types/task';
import { User } from '@/types/usertype';

defineProps<{
    statuses: TaskStatus[],
    priorities: TaskPriority[],
    users: User[],


}>();

const form = useForm({
    task_name: '',
    task_description: '',
    task_status: '',
    task_priority: '',
    task_deadline: '',
    assign_to: '',
})

function addTask( id?: number) {
    form.post(`admin/projects/${id}/tasks`, {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>
