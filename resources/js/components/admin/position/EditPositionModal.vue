<template>
    <div>
        <Dialog v-model:open="open" >
      <DialogContent class="sm:max-w-[425px]">
          <form @submit.prevent="editPosition()">
        <DialogHeader>
          <DialogTitle>Edit Position</DialogTitle>
          <DialogDescription>

          </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4">

          <div class="grid gap-3">
            <Label >Position Name</Label>
            <Input v-model="form.position_name"  placeholder="e.g Quality Control"/>
            <span class="text-red-500 text-sm">{{ form.errors.position_name }}</span>
          </div>
        </div>
        <DialogFooter class="mt-4">
          <DialogClose as-child>
            <Button variant="outline">
              Cancel
            </Button>
          </DialogClose>
          <Button type="submit" class="bg-[#22C55E] hover:bg-[#16A34A]">
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
import { Position } from '@/types/usertype';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{ position: Position | null }>()
const open = defineModel('open')

const form = useForm({ position_name: '' })


function editPosition(){
    form.put(`/admin/positions/${props.position?.id}`,{
        onSuccess: () => {
            open.value = false;
        },
    });
}


</script>


