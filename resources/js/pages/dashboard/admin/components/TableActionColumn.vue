<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import { Row } from '@tanstack/vue-table';
import { Edit, Trash } from 'lucide-vue-next';

const props = defineProps<{
   row: Row<any>;
   canDelete?: boolean;
   editRouteName: string;
}>();

const emit = defineEmits<{
   (e: 'confirm-delete', id: number): void;
}>();
</script>

<template>
   <div class="flex items-center gap-2">
      <Button
         as="a"
         :href="route(props.editRouteName, { id: props.row.original.id })"
         variant="default"
         size="icon"
         class="cursor-pointer bg-yellow-400"
      >
         <Edit :size="16" class="text-black" />
      </Button>

      <Button
         as="button"
         variant="destructive"
         size="icon"
         class="cursor-pointer"
         @click="emit('confirm-delete', props.row.original.id)"
         :disabled="!props.canDelete"
      >
         <Trash :size="16" class="text-black" />
      </Button>
   </div>
</template>
