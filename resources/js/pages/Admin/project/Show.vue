<template>
    <div class="mt-8 px-3">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <div class="bg-white border border-gray-100 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-11 h-11 rounded-xl bg-[#E1F5EE] flex items-center justify-center shrink-0">
                        <ListCheckIcon class="w-5 h-5 text-[#0F6E56]" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400">Total tasks</p>
                        <p class="text-xl font-semibold">{{ }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-11 h-11 rounded-xl bg-[#E6F1FB] flex items-center justify-center shrink-0">
                        <Loader class="w-5 h-5 text-[#185FA5]" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400">In progress</p>
                        <p class="text-xl font-semibold">{{ }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-11 h-11 rounded-xl bg-[#DCFCE7] flex items-center justify-center shrink-0">
                        <CircleCheck class="w-5 h-5 text-[#16A34A]" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400">Completed</p>
                        <p class="text-xl font-semibold">{{ }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-11 h-11 rounded-xl bg-[#FAEEDA] flex items-center justify-center shrink-0">
                        <Pause class="w-5 h-5 text-[#854F0B]" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400">On hold</p>
                        <p class="text-xl font-semibold">{{ }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-11 h-11 rounded-xl bg-[#EEEDFE] flex items-center justify-center shrink-0">
                        <Eye class="w-5 h-5 text-[#534AB7]" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400">For checking</p>
                        <p class="text-xl font-semibold">{{ }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Project } from '@/types/usertype';
import AdminLayout from '@/layouts/user/AdminLayout.vue';
import ProjectLayout from '@/layouts/user/ProjectLayout.vue';
import { CircleCheck, Eye, ListCheckIcon, Loader, Pause } from 'lucide-vue-next';


defineOptions({
    layout: [AdminLayout, ProjectLayout],
})

defineProps<{
    projects: Project,
}>()


</script>


