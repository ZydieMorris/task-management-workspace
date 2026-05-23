<template>
    <div>

 <Table>
    <TableCaption></TableCaption>
    <TableHeader class="bg-p[#E4ECE5]">
      <TableRow >
        <TableHead >
          Position
        </TableHead>

      </TableRow>
    </TableHeader>
    <TableBody v-for="p in positions" :key="p.id">
      <TableRow>
        <TableCell class="flex justify-between">
          {{p.position_name  }}

          <Popover>
            <PopoverTrigger> <Ellipsis class="w-4 "/></PopoverTrigger>
            <PopoverContent class=" text-sm " side="left" align="start">
                <button @click="emit('edit', p)"  class="flex items-center gap-3 text-blue-500 hover:bg-gray-100">
                    <Pencil class="w-4 h-4" /> Edit
                </button>

                 <AlertDialog>
                    <AlertDialogTrigger class="flex items-center gap-3 text-red-500 hover:bg-gray-100"> <Trash class="w-4 h-4" /> Delete</AlertDialogTrigger>
                    <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                        <AlertDialogDescription>
                        This action cannot be undone. This will permanently the data.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction @click="deletePosition(p.id)">Yes</AlertDialogAction>
                    </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </PopoverContent>
        </Popover>

        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
    </div>
</template>

<script setup lang="ts">
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableFooter,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { Position } from '@/types/usertype';
import { Ellipsis, Pencil, PencilIcon, Trash } from 'lucide-vue-next';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import {router} from '@inertiajs/vue3';
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


defineProps<{
    positions: Position[],
}>();

const emit = defineEmits(['edit']);

function deletePosition(id: number){
    router.delete(`/admin/positions/${id}`)
}

</script>


