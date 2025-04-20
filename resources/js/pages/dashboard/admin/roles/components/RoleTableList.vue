<script lang="ts" setup>

import DeleteDialog from '@/components/DeleteDialog.vue';
import {
   Table,
   TableBody,
   TableHead,
   TableHeader,
   TableRow,
   TableCell
} from '@/components/ui/table';
import { Role } from '@/types';
import { router } from '@inertiajs/vue3';
import { ColumnDef, FlexRender, getCoreRowModel, getPaginationRowModel, useVueTable } from '@tanstack/vue-table';
import { computed, h, ref } from 'vue';
import TableActionColumn from '../../components/TableActionColumn.vue';
import DataTablePagination from '../../components/DataTablePagination.vue';

const props = defineProps<{
   roles: Role[];
}>();
const roles = computed(() => Array.isArray(props.roles) ? props.roles : []);

const columns: ColumnDef<Role>[] = [
   {
      accessorKey: 'name',
      header: 'Roles List',
   },
   {
      accessorKey: 'permission',
      header: 'Permission List',
   },
   {
      header: 'Actions',
      cell: ({ row }) => h(TableActionColumn, {
         row,
         onConfirmDelete: (rolesId: number) => openConfirmDialog(rolesId),
         canDelete: true,
         editRouteName: 'admin.roles.show',
      }),
   }
];

const pagination = ref({
   pageIndex: 0,
   pageSize: 15,
});

const table = useVueTable({
   data: roles.value,
   columns,
   getCoreRowModel: getCoreRowModel(),
   getPaginationRowModel: getPaginationRowModel(),
   state: {
      pagination: pagination.value,
   },
   onPaginationChange: (updater) => {
      pagination.value = typeof updater === 'function'
         ? updater(pagination.value)
         : updater;
   },
});

const showDialog = ref(false);
const selectedRoleId = ref<number | null>(null);

function openConfirmDialog(roleId: number) {
   selectedRoleId.value = roleId;
   showDialog.value = true;
}

function confirmDelete() {
   if (selectedRoleId.value !== null) {
      router.delete(route('admin.roles.delete', { id: selectedRoleId.value }));
      showDialog.value = false;
   }
}

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
                     <TableCell>
                        <FlexRender :render="cell.column.columnDef.cell"
                           :props="{ ...cell.getContext(), onConfirmDelete: openConfirmDialog }" />
                     </TableCell>
                  </template>
               </TableRow>
            </template>
            <template v-else>
               <TableRow>
                  <TableCell :colspan="columns.length" class="text-center">
                     No roles available yet.
                  </TableCell>
               </TableRow>
            </template>
         </TableBody>
      </Table>

   </div>

   <DataTablePagination :table="table" />
   <DeleteDialog v-model="showDialog" :confirmDelete="confirmDelete" />

</template>