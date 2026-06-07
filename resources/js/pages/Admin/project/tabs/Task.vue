<template>
    <div class="flex">
    <!-- Task list panel -->
    <div class="flex-[5] min-h-[30rem] bg-white border border-gray-200/60  p-4">

        <div class="flex justify-end">
            <AddTaskModal :statuses="statuses" :priorities="priorities" :users="users"/>
        </div>

        <div class="mt-2">
            <Accordion type="single" collapsible class="w-full" default-value="item-1">
                <AccordionItem class="bg-gray-400 rounded-xl" value="item-1">
                <AccordionTrigger class="text-lg">To do</AccordionTrigger>
                <AccordionContent>
                    <p>
                    Our flagship product combines cutting-edge technology with sleek
                    design. Built with premium materials, it offers unparalleled
                    performance and reliability.
                    </p>
                    <p class="mt-2">
                    Key features include advanced processing capabilities, and an
                    intuitive user interface designed for both beginners and experts.
                    </p>
                </AccordionContent>
                </AccordionItem>

            </Accordion>
        </div>

    </div>

    <!-- Detail / sidebar panel -->
    <div class="flex-[3] min-h-[30rem] bg-white border border-gray-200/60  p-4">
      <!-- task detail goes here -->
    </div>
  </div>
</template>

<script setup lang="ts">
import { Project } from '@/types/usertype';
import AdminLayout from '@/layouts/user/AdminLayout.vue';
import ProjectLayout from '@/layouts/user/ProjectLayout.vue';
import AddTaskModal from '@/components/admin/position/task/AddTaskModal.vue';
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from '@/components/ui/accordion'
import { TaskStatus } from '@/types/task';
import { TaskPriority } from '@/types/task';
import { User } from '@/types/usertype';

defineOptions({
    layout: [AdminLayout, ProjectLayout],
})

defineProps<{
    projects: Project,
    statuses: TaskStatus[],
    priorities: TaskPriority[],
    users: User[],
}>()
</script>
