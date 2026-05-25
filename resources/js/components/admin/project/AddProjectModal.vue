<template>
    <div>
        <Dialog v-model:open="open">

      <DialogTrigger as-child>
        <Button class="bg-[#22C55E] hover:bg-[#16A34A]">
            <Plus/>
          Add Project
        </Button>
      </DialogTrigger>
      <DialogContent class="sm:max-w-[425px]">
          <form @submit.prevent="addProject">
        <DialogHeader>
          <DialogTitle></DialogTitle>
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
           Add Project
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
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { Textarea } from '@/components/ui/textarea';
import { ref } from 'vue';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { opendir } from 'fs/promises';

const props = defineProps<{
    severity: string[];
}>();

const form = useForm({
    project_name: '',
    project_description: '',
    project_severity: '',
    deployment_date: '',
});

const open = ref(false);

function addProject(){
    form.post('/admin/projects', {
        onSuccess: () => {
            form.reset();
            open.value = false;
        }
    })
}


</script>


