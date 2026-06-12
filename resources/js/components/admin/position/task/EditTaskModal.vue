<template>
    <Dialog v-model:open="dialogOpen">
      <DialogContent class="sm:max-w-[425px]">
        <form @submit.prevent="updateTask">
          <DialogHeader>
            <DialogTitle>Edit Task</DialogTitle>
            <DialogDescription></DialogDescription>
          </DialogHeader>
          <div class="grid gap-4">
            <div class="grid gap-3">
              <Label>Task Name</Label>
              <Input v-model="form.task_name" />
              <span class="text-red-500 text-sm">{{ form.errors.task_name }}</span>
            </div>
            <div class="grid gap-3">
              <Label>Description</Label>
              <Textarea v-model="form.task_description" placeholder="add notes.." />
            </div>
            <div class="grid gap-3">
              <Label>Status</Label>
              <Select v-model="form.task_status">
                <SelectTrigger class="w-[180px]">
                  <SelectValue placeholder="Select a status" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel></SelectLabel>
                    <SelectItem v-for="s in statusNames" :key="s" :value="s">{{ s }}</SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <span class="text-red-500 text-sm">{{ form.errors.task_status }}</span>
            </div>
            <div class="grid gap-3">
              <Label>Priority</Label>
              <Select v-model="form.task_priority">
                <SelectTrigger class="w-[180px]">
                  <SelectValue placeholder="Select a priority" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel></SelectLabel>
                    <SelectItem v-for="p in priorities" :key="p" :value="p">{{ p }}</SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <span class="text-red-500 text-sm">{{ form.errors.task_priority }}</span>
            </div>
            <div class="grid gap-3">
              <Label>Deadline</Label>
              <Input type="date" v-model="form.task_deadline" />
              <span class="text-red-500 text-sm">{{ form.errors.task_deadline }}</span>
            </div>
            <div class="grid gap-3">
              <Label>Assign To</Label>
              <Select v-model="form.assign_to">
                <SelectTrigger class="w-[180px]">
                  <SelectValue placeholder="Select a user" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel></SelectLabel>
                    <SelectItem v-for="u in users" :key="u.id" :value="u.id">{{ u.name }}</SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <span class="text-red-500 text-sm">{{ form.errors.assign_to }}</span>
            </div>
          </div>
          <DialogFooter>
            <DialogClose as-child>
              <Button variant="outline">Cancel</Button>
            </DialogClose>
            <Button type="submit" :disabled="form.processing">Save changes</Button>
          </DialogFooter>
        </form>
      </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import { watch, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
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
import type { TaskPriority, Task } from '@/types/task';
import type { User } from '@/types/usertype';

const props = defineProps<{
    projectId: number;
    task: Task | null;
    statusNames: string[];
    priorities: TaskPriority[];
    users: User[];
    open: boolean;
}>();

const emit = defineEmits<{
    (e: 'update:open', value: boolean): void;
}>();

const dialogOpen = computed({
    get: () => props.open,
    set: (val) => emit('update:open', val),
})

const form = useForm({
    task_name: '',
    task_description: '',
    task_status: '',
    task_priority: '',
    task_deadline: '',
    assign_to: '',
})

watch(() => props.task, (task) => {
    if (task) {
        form.task_name = task.task_name
        form.task_description = task.task_description
        form.task_status = task.task_status
        form.task_priority = task.task_priority
        form.task_deadline = task.task_deadline ? task.task_deadline.split('T')[0] : ''
        form.assign_to = task.assign_to
    }
}, { immediate: true })

function updateTask() {
    form.put(`/admin/projects/${props.projectId}/tasks/${props.task?.id}`, {
        onSuccess: () => {
            form.reset()
            emit('update:open', false)
        }
    })
}
</script>
