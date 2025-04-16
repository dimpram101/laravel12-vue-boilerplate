<script lang="ts" setup>

import {
   Table,
   TableBody,
   TableHead,
   TableHeader,
   TableRow
} from '@/components/ui/table';
import TableCell from '@/components/ui/table/TableCell.vue';
import { User } from '@/types';
import { Role } from '@/types/model';
import { ColumnDef, FlexRender, getCoreRowModel, getPaginationRowModel, useVueTable } from '@tanstack/vue-table';
import { computed, ref } from 'vue';
import DataTablePagination from './DataTablePagination.vue';

const props = defineProps<{
   users: User[];
}>();

const columns: ColumnDef<User>[] = [
   {
      accessorKey: 'name',
      header: 'Name',
   },
   {
      accessorKey: 'email',
      header: 'Email',
   },
   {
      accessorKey: 'roles',
      header: 'Role',
      cell: ({ row }) => {
         const roles = row.getValue('roles') as Role[];
         return roles.length > 0 ? roles.map(item => item.name).join(', ') : 'No Role';
      },
   },
   {
      accessorKey: 'created_at',
      header: 'Created At',
      cell: ({ row }) => {
         const date = new Date(row.getValue('created_at'));
         return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
         });
      },
   },
];
const pagination = ref({
   pageIndex: 0,
   pageSize: 15,
});
const table = computed(() => useVueTable({
   data: props.users,
   columns,
   getCoreRowModel: getCoreRowModel(),
   getPaginationRowModel: getPaginationRowModel(),
   state: {
      pagination: pagination.value,
   },
   onPaginationChange: (updater) => {
      if (typeof updater === 'function') {
         pagination.value = updater(pagination.value);
      } else {
         pagination.value = updater;
      }
   },
}))

</script>

<template>
   <div class="rounded-md border">
      <Table>
         <TableHeader>
            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
               <TableHead v-for="header in headerGroup.headers" :key="header.id">
                  {{ header.column.columnDef.header }}
               </TableHead>
            </TableRow>
         </TableHeader>
         <TableBody>
            <template v-if="table.getRowModel().rows.length > 0">
               <TableRow v-for="row in table.getRowModel().rows" :key="row.id" class="h-12">
                  <template v-for="cell in row.getVisibleCells()" :key="cell.id">
                     <TableCell>
                        <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                     </TableCell>
                  </template>
               </TableRow>
            </template>
            <template v-else>
               <TableRow>
                  <TableCell :colspan="columns.length" class="text-center">
                     No data available.
                  </TableCell>
               </TableRow>
            </template>
         </TableBody>
      </Table>

   </div>

   <DataTablePagination :table="table" />
   <!-- <div class="flex items-center justify-between mt-4">
      <div class="text-sm text-muted-foreground">
         Page {{ table.getState().pagination.pageIndex + 1 }} of {{ table.getPageCount() }}
      </div>
      <div class="flex items-center space-x-2">
         <Button variant="outline" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()">
            Previous
         </Button>
         <Button variant="outline" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
            Next
         </Button>
      </div>
   </div> -->
</template>