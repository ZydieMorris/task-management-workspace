<template>
    <div>
        <Dialog v-model:open="open">

      <DialogTrigger as-child>
        <Button class="bg-[#22C55E] hover:bg-[#16A34A]">
            <Plus/>
          Add Position
        </Button>
      </DialogTrigger>
      <DialogContent class="sm:max-w-[425px]">
          <form @submit.prevent="submit">
        <DialogHeader>
          <DialogTitle></DialogTitle>
          <DialogDescription>

          </DialogDescription>
        </DialogHeader>
        <div class="grid gap-4">

          <div class="grid gap-3">
            <Label >Position Name</Label>
            <Input  v-model="form.position_name" placeholder="e.g Quality Control" class="border-[#22C55E]"/>
            <span class="text-red-500 text-sm">{{ form.errors.position_name }}</span>
            <span v-if="errorMessage" class="text-sm text-red-500">{{ errorMessage }}</span>
          </div>
        </div>
        <DialogFooter class="mt-4">
          <DialogClose as-child>
            <Button variant="outline">
              Cancel
            </Button>
          </DialogClose>
          <Button type="submit" class="bg-[#22C55E]  hover:bg-[#16A34A]">
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
import { useToast } from '@/composables/useToast';
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';

const {show} = useToast();



const form = useForm({
    position_name: '',
})

const errorMessage = ref('');
const open = ref(false);
function submit() {
    if(form.position_name.length === 0 ){
        errorMessage.value = 'Position name is required.';

        setTimeout(() => {
            errorMessage.value = '';
        }, 2000);

        return;
    }
    form.post('/admin/positions',{
        onSuccess: () => {
            show ('Position Successfully Added');
            form.reset();
            open.value = false;

        },
    })
}


</script>


