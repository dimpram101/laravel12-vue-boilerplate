<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Role } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';
import { UserPlus } from 'lucide-vue-next';
import { h, ref } from 'vue';
import DataTable from '../components/DataTable.vue';
import HeaderAction from '../components/HeaderAction.vue';
import TableActionColumn from '../components/TableActionColumn.vue';
import PermissionChip from './components/PermissionChip.vue';

const breadcrumbs: BreadcrumbItem[] = [
   {
      title: 'Dashboard',
      href: '/dashboard',
   },
   {
      title: 'Roles',
      href: route('admin.roles.index'),
   },
];

const props = defineProps<{
   roles: Role[];
}>();

const dataTableRef = ref<InstanceType<typeof DataTable>>();

const columns: ColumnDef<Role>[] = [
   {
      accessorKey: 'name',
      header: 'Role',
   },
   {
      header: 'Permissions',
      cell: ({ row }) =>
         h('div', { class: 'max-w-[540px]' }, [
            h(PermissionChip, {
               permissions: row.original.permissions,
            }),
         ]),
   },
   {
      accessorKey: 'actions',
      header: 'Actions',
      cell: ({ row }) =>
         h(TableActionColumn, {
            row,
            canDelete: true,
            editRouteName: 'admin.roles.show',
            onConfirmDelete: (id: number) => dataTableRef.value?.openConfirmDialog(id),
         }),
   },
];
</script>

<template>
   <Head title="Roles" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <template #header-actions>
         <HeaderAction label="Add Role" :icon="UserPlus" :href="route('admin.roles.create')" />
      </template>

      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <DataTable
            ref="dataTableRef"
            :data="props.roles"
            :columns="columns"
            deleteRouteName="admin.roles.delete"
            :cellAligns="{
               name: 'align-top',
               permissions: 'align-top',
               actions: 'align-top',
            }"
         >
            <template #delete-dialog-content>
               <p class="text-muted-foreground text-sm">
                  Are you sure want to delete this <strong>role</strong>? This action cannot be undone. This will permanently delete the data.
               </p>
            </template>
         </DataTable>
      </div>
   </AppLayout>
</template>
