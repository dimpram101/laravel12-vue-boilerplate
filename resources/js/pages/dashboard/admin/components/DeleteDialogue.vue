<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';

const props = defineProps<{
   modelValue: boolean;
}>();

const emit = defineEmits<{
   (e: 'update:modelValue', value: boolean): void;
   (e: 'confirm'): void;
}>();

function close() {
   emit('update:modelValue', false);
}

function confirm() {
   emit('confirm');
   close();
}
</script>

<template>
   <Dialog :open="props.modelValue" @update:open="(v) => emit('update:modelValue', v)">
      <DialogContent>
         <DialogHeader>
            <DialogTitle>Delete Confirmation</DialogTitle>
         </DialogHeader>

         <slot />

         <DialogFooter>
            <Button variant="outline" class="cursor-pointer" @click="close">Cancel</Button>
            <Button variant="destructive" class="cursor-pointer" @click="confirm">Yes, delete</Button>
         </DialogFooter>
      </DialogContent>
   </Dialog>
</template>
