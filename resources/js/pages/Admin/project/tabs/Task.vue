<template>
    <div class="flex">
    <!-- Task list panel -->
    <div class="flex-[5] min-h-[30rem] bg-white border border-gray-200/60  p-4">

        <div class="flex justify-end">
            <AddTaskModal :project="projects" :statuses="statusNames" :priorities="priorities" :users="users"/>
        </div>
        <!-- Task List -->
        <div class="mt-2">
            <Accordion type="single" collapsible class="w-full" >
                <AccordionItem class="bg-gray-50 rounded mb-5" v-for="s in statuses" :key="s.name" :value="s.name">
                <AccordionTrigger class="text-lg">
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xs px-2 py-0.5 rounded-full font-medium"
                            :class="statusColors[s.name]"
                        >
                            {{ s.name }}
                        </span>
                        <span class="text-xs text-gray-400">({{ s.tasks.length }})</span>
                    </div>
                </AccordionTrigger>
               <AccordionContent>
                    <div v-if="s.tasks.length === 0" class="px-4 py-3 text-sm text-gray-400">
                        No tasks yet.
                    </div>

                    <table v-else class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-400 border-b border-gray-100">
                                <th class="py-2 px-3 font-medium">Task</th>
                                <th class="py-2 px-3 font-medium">Priority</th>
                                <th class="py-2 px-3 font-medium">Deadline</th>
                                <th class="py-2 px-3 font-medium"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="task in s.tasks"
                                :key="task.id"
                                @click="selectTask(task)"
                                class="border-b border-gray-50 hover:bg-gray-50 cursor-pointer"
                            >
                                <td class="py-2 px-3">{{ task.task_name }}</td>
                                <td class="py-2 px-3">{{ task.task_priority }}</td>
                                <td class="py-2 px-3">
    {{ new Date(task.task_deadline).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) }}
</td>
                                <td class="py-2 px-3" @click.stop>
                                    <Popover>
                                        <PopoverTrigger>
                                            <Ellipsis class="w-4 cursor-pointer" />
                                        </PopoverTrigger>
                                        <PopoverContent class="w-36 p-1 text-sm" side="left" align="start">
                                            <button
                                                @click="openEdit(task)"
                                                class="flex w-full items-center gap-3 rounded px-2 py-1.5 text-blue-500 hover:bg-gray-100"
                                            >
                                                <Pencil class="w-4 h-4" /> Edit
                                            </button>
                                            <AlertDialog>
                                                <AlertDialogTrigger
                                                    class="flex w-full items-center gap-3 rounded px-2 py-1.5 text-red-500 hover:bg-gray-100"
                                                >
                                                    <Trash class="w-4 h-4" /> Delete
                                                </AlertDialogTrigger>
                                                <AlertDialogContent>
                                                    <AlertDialogHeader>
                                                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                                                        <AlertDialogDescription>
                                                            This action cannot be undone. This will permanently delete the task.
                                                        </AlertDialogDescription>
                                                    </AlertDialogHeader>
                                                    <AlertDialogFooter>
                                                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                                                        <AlertDialogAction @click="deleteTask(task.id)">Yes</AlertDialogAction>
                                                    </AlertDialogFooter>
                                                </AlertDialogContent>
                                            </AlertDialog>
                                        </PopoverContent>
                                    </Popover>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </AccordionContent>
                </AccordionItem>

            </Accordion>
        </div>
    </div>


  <!-- Detail / sidebar panel -->
<div class="flex-[3] min-h-[30rem] bg-white border border-gray-200/60 p-4">
    <div v-if="!selectedTask" class="text-sm text-gray-400">
        Select a task to view details.
    </div>

    <div v-else>
        <h2 class="text-lg font-semibold">{{ selectedTask.task_name }}</h2>
        <p class="text-sm text-gray-500 mt-1">{{ selectedTask.task_description }}</p>

        <div class="mt-4 flex flex-col gap-2 text-sm">
            <div>
                <span class="text-gray-400">Priority:</span>
                <span class="ml-2">{{ selectedTask.task_priority }}</span>
            </div>
            <div>
                <span class="text-gray-400">Status:</span>
                <span class="ml-2">{{ selectedTask.task_status }}</span>
            </div>
            <div>
                <span class="text-gray-400">Deadline:</span>
                <span class="ml-2">{{ new Date(selectedTask.task_deadline).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) }}</span>
            </div>
            <div>
                <span class="text-gray-400">Assigned To:</span>
                <span class="ml-2">{{ selectedTask.assign_to }}</span>
            </div>
        </div>
    </div>
</div>

  </div>

    <EditTaskModal
        v-model:open="showEditModal"
        :project-id="projects.id"
        :task="editingTask"
        :status-names="statusNames"
        :priorities="priorities"
        :users="users"
    />
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import AddTaskModal from '@/components/admin/position/task/AddTaskModal.vue';
import EditTaskModal from '@/components/admin/position/task/EditTaskModal.vue';
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from '@/components/ui/accordion'
import AdminLayout from '@/layouts/user/AdminLayout.vue';
import ProjectLayout from '@/layouts/user/ProjectLayout.vue';
import type { TaskPriority, Task } from '@/types/task';
import type { Project, User } from '@/types/usertype';
import { Ellipsis, Pencil, Trash } from 'lucide-vue-next';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog'

defineOptions({
    layout: [AdminLayout, ProjectLayout],
})

import { ref, computed } from 'vue'


const selectedTask = ref<Task | null>(null)

const selectTask = (task: Task) => {
    selectedTask.value = task
}

type StatusWithTasks = {
    name: string
    tasks: Task[]
}

const props = defineProps<{
    projects: Project,
    statuses: StatusWithTasks[],
    priorities: TaskPriority[],
    users: User[],
}>()

const statusNames = computed(() => props.statuses.map(s => s.name))

const showEditModal = ref(false)
const editingTask = ref<Task | null>(null)

function openEdit(task: Task) {
    editingTask.value = task
    showEditModal.value = true
}

function deleteTask(taskId: number) {
    router.delete(`/admin/projects/${props.projects.id}/tasks/${taskId}`)
}

const statusColors: Record<string, string> = {
    'To Do'       : 'bg-gray-100 text-gray-600',
    'In Progress' : 'bg-blue-100 text-blue-600',
    'For Checking': 'bg-yellow-100 text-yellow-600',
    'On Hold'     : 'bg-orange-100 text-orange-600',
    'Completed'   : 'bg-green-100 text-green-600',
}
</script>
