<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import { Row } from '@tanstack/vue-table';
import { Edit, Trash } from 'lucide-vue-next';

const props = defineProps<{
   row: Row<any>;
   canDelete: boolean;
   canEdit: boolean;
   editRouteName?: string;
   onEdit?: (row: any) => void;
}>();

const emit = defineEmits<{
   (e: 'confirm-delete', id: number): void;
}>();

function handleEdit() {
   if (props.onEdit) {
      props.onEdit(props.row.original);
   } else if (props.editRouteName) {
      window.location.href = route(props.editRouteName, { id: props.row.original.id });
   }
}
</script>

<template>
   <div class="flex items-center gap-2">
      <Button type="button" variant="default" size="icon" class="cursor-pointer bg-yellow-400" @click="handleEdit" :disabled="!props.canEdit">
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
