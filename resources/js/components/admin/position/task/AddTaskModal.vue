<template>
    <div>
        <Dialog v-model:open="open">
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
            <Label>Task Name</Label>
            <Input v-model="form.task_name" placeholder="e.g "/>
            <span class="text-red-500 text-sm">{{ form.errors.task_name }}</span>
          </div>
          <div class="grid gap-3">
            <Label>Description</Label>
            <Textarea v-model="form.task_description" placeholder="add notes.." />
          </div>

          <!-- task status -->
          <div class="grid gap-3">
            <Label>Status</Label>
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
            <span class="text-red-500 text-sm">{{ form.errors.task_status }}</span>
          </div>

            <!-- task priority -->
             <div class="grid gap-3">
            <Label>Priority</Label>
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
            <span class="text-red-500 text-sm">{{ form.errors.task_priority }}</span>
          </div>

           <!-- task deadline -->
             <div class="grid gap-3">
            <Label>Deadline</Label>
            <Input type="date" v-model="form.task_deadline"/>
            <span class="text-red-500 text-sm">{{ form.errors.task_deadline }}</span>
          </div>

          <!-- Assign to -->
        <div class="grid gap-3">
            <Label>Assign To</Label>
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
            <span class="text-red-500 text-sm">{{ form.errors.assign_to }}</span>
          </div>

        </div>
        <DialogFooter>
          <DialogClose as-child>
            <Button variant="outline">
              Cancel
            </Button>
          </DialogClose>
          <Button type="submit" :disabled="form.processing">
            Save changes
          </Button>
        </DialogFooter>
    </form>
      </DialogContent>
  </Dialog>
    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';
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
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import Textarea from '@/components/ui/textarea/Textarea.vue';
import type { TaskStatus, TaskPriority } from '@/types/task';
import type { User } from '@/types/usertype';

const props = defineProps<{
    project: { id: number };
    statuses: TaskStatus[];
    priorities: TaskPriority[];
    users: User[];
}>();

const form = useForm({
    task_name: '',
    task_description: '',
    task_status: '',
    task_priority: '',
    task_deadline: '',
    assign_to: '',
})

const open = ref(false);

function addTask() {
    form.post(`/admin/projects/${props.project.id}/tasks`, {
        onSuccess: () => {
            form.reset();
            open.value = false;
        }
    });
}
</script>
