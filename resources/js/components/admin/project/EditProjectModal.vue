<template>
    <div>
        <Dialog v-model:open="open">

      <DialogContent class="sm:max-w-[425px]">
          <form @submit.prevent="editProject()">
        <DialogHeader>
          <DialogTitle>Edit Project</DialogTitle>
          <DialogDescription>

          </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4">

          <div class="grid gap-3">
            <Label >Project Name</Label>
            <Input  v-model="form.project_name" placeholder="e.g Quality Control" class="border-[#22C55E]"/>
            <span class="text-red-500 text-sm">{{ form.errors.project_name }}</span>
          </div>

        <div class="grid gap-3">
            <Label >Desription</Label>
            <Textarea  v-model="form.project_description" placeholder="e.g Quality Control" class="border-[#22C55E]"/>
          </div>

        <div class="grid gap-3">
            <Label >Severity</Label>
            <Select v-model="form.project_severity">
                <SelectTrigger class="w-[180px]">
                <SelectValue placeholder="Select severity" />
                </SelectTrigger>
                <SelectContent>
                <SelectGroup>
                    <SelectLabel></SelectLabel>
                    <SelectItem v-for="s in severity" :key="s" :value="s">
                        {{ s }}

                    </SelectItem>
                </SelectGroup>
                </SelectContent>
            </Select>
        </div>

        <div class="grid gap-3">
            <Label >Deployment Date</Label>
            <Input type="date" v-model="form.deployment_date" placeholder="e.g Quality Control" class="border-[#22C55E]"/>
        </div>


        </div>
        <DialogFooter class="mt-4">
          <DialogClose as-child>
            <Button variant="outline">
              Cancel
            </Button>
          </DialogClose>
          <Button type="submit" :disabled="form.processing" class="bg-[#22C55E]  hover:bg-[#16A34A]">
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
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { useForm } from '@inertiajs/vue3';
import { Textarea } from '@/components/ui/textarea';
import { watch } from 'vue';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'

const open = defineModel('open')

const props = defineProps<{
    severity: string[];
    project: any;
}>();

const form = useForm({
    project_name: '',
    project_description: '',
    project_severity: '',
    deployment_date: '',
});

watch(() => props.project, (newProject) => {
    if (newProject) {
        form.project_name = newProject.project_name;
        form.project_description = newProject.project_description;
        form.project_severity = newProject.project_severity;
        form.deployment_date = newProject.deployment_date;
    }
}, { immediate: true });

function editProject(){
    form.put(`/admin/projects/${props.project?.id}`, {
        onSuccess: () => {
            open.value = false;
        },
    })
}


</script>


