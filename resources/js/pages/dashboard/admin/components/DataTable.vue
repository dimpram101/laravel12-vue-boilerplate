<script lang="ts" setup>
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { router } from '@inertiajs/vue3';
import { ColumnDef, FlexRender, getCoreRowModel, getPaginationRowModel, useVueTable } from '@tanstack/vue-table';
import { computed, defineProps, ref } from 'vue';
import DataTablePagination from './DataTablePagination.vue';
import DeleteDialogue from './DeleteDialogue.vue';

const props = defineProps<{
   data: any[];
   columns: ColumnDef<any>[];
   deleteRouteName?: string;
   cellAligns?: Record<string, string>;
}>();

const pagination = ref({
   pageIndex: 0,
   pageSize: 15,
});

const table = computed(() =>
   useVueTable({
      data: props.data,
      columns: props.columns,
      getCoreRowModel: getCoreRowModel(),
      getPaginationRowModel: getPaginationRowModel(),
      state: {
         pagination: pagination.value,
      },
      onPaginationChange: (updater) => {
         pagination.value = typeof updater === 'function' ? updater(pagination.value) : updater;
      },
   }),
);

const showDialog = ref(false);
const selectedId = ref<number | null>(null);

function openConfirmDialog(id: number) {
   selectedId.value = id;
   showDialog.value = true;
}

function confirmDelete() {
   if (selectedId.value !== null && props.deleteRouteName) {
      router.delete(route(props.deleteRouteName, { id: selectedId.value }), {
         preserveState: false,
      });
      showDialog.value = false;
   }
}

defineExpose({
   openConfirmDialog,
});
</script>

<template>
   <div class="rounded-md border">
      <Table>
         <TableHeader>
            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
               <TableHead v-for="header in headerGroup.headers" :key="header.id" class="text-bold">
                  {{ header.column.columnDef.header }}
               </TableHead>
            </TableRow>
         </TableHeader>
         <TableBody>
            <template v-if="table.getRowModel().rows.length > 0">
               <TableRow v-for="row in table.getRowModel().rows" :key="row.id" class="h-12">
                  <template v-for="cell in row.getVisibleCells()" :key="cell.id">
                     <TableCell :class="[props.cellAligns?.[cell.column.id]]">
                        <FlexRender :render="cell.column.columnDef.cell" :props="{ ...cell.getContext() }" />
                     </TableCell>
                  </template>
               </TableRow>
            </template>
            <template v-else>
               <TableRow>
                  <TableCell :colspan="props.columns.length" class="text-center"> No data available yet. </TableCell>
               </TableRow>
            </template>
         </TableBody>
      </Table>
   </div>

   <DataTablePagination :table="table" />

   <DeleteDialogue v-model="showDialog" @confirm="confirmDelete">
      <slot name="delete-dialog-content">
         <p class="text-muted-foreground text-sm">This action cannot be undone. This will permanently delete the data.</p>
      </slot>
   </DeleteDialogue>
</template>
