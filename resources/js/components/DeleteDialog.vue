<script lang="ts" setup>

import { Button } from '@/components/ui/button';
import {
   Dialog,
   DialogContent,
   DialogDescription,
   DialogFooter,
   DialogHeader,
   DialogTitle,
} from '@/components/ui/dialog';

const props = defineProps<{
   modelValue: boolean;
   confirmDelete: () => void;
}>();

const emit = defineEmits<{
   (e: 'update:modelValue', value: boolean): void;
}>();
</script>

<template>
   <Dialog :open="props.modelValue" @close="emit('update:modelValue', false)">
      <DialogContent>
         <DialogHeader>
            <DialogTitle>Are you sure?</DialogTitle>
            <DialogDescription>
               This action cannot be undone. This will permanently delete the data.
            </DialogDescription>
         </DialogHeader>
         <DialogFooter class="mt-4">
            <Button variant="outline" @click="emit('update:modelValue', false)" class="cursor-pointer">Cancel</Button>
            <Button variant="destructive" @click="confirmDelete" class="cursor-pointer">Yes, delete</Button>
         </DialogFooter>
      </DialogContent>
   </Dialog>
</template>