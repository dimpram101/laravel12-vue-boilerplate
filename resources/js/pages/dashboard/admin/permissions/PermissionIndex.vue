<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Permission } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ColumnDef } from '@tanstack/vue-table';
import { FilePlus } from 'lucide-vue-next';
import { h, ref } from 'vue';
import DataTable from '../components/DataTable.vue';
import HeaderAction from '../components/HeaderAction.vue';
import TableActionColumn from '../components/TableActionColumn.vue';
import CreateDialogue from './components/CreateDialogue.vue';
import EditDialogue from './components/EditDialogue.vue';

const breadcrumbs: BreadcrumbItem[] = [
   {
      title: 'Dashboard',
      href: '/dashboard',
   },
   {
      title: 'Permissions',
      href: route('admin.permissions.index'),
   },
];

const props = defineProps<{
   permissions: Permission[];
   can: {
      create: boolean;
      update: boolean;
      delete: boolean;
   };
}>();

const dataTableRef = ref<InstanceType<typeof DataTable>>();
const showCreateModal = ref(false);

const showEditModal = ref(false);
const selectedPermission = ref<Permission | null>(null);

const columns: ColumnDef<Permission>[] = [
   {
      accessorKey: 'name',
      header: 'Permission',
   },
   {
      header: 'Actions',
      cell: ({ row }) =>
         h(TableActionColumn, {
            row,
            canDelete: props.can.delete,
            canEdit: props.can.update,
            onEdit: (permission: Permission) => {
               selectedPermission.value = permission;
               showEditModal.value = true;
            },
            onConfirmDelete: (id: number) => dataTableRef.value?.openConfirmDialog(id),
         }),
   },
];
</script>

<template>
   <Head title="Permissions" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <template #header-actions>
         <HeaderAction label="Add Permission" :icon="FilePlus" @click="showCreateModal = true" :disabled="!props.can.create"/>
         <CreateDialogue :open="showCreateModal" @close="showCreateModal = false" />
      </template>

      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <DataTable ref="dataTableRef" :data="props.permissions" :columns="columns" deleteRouteName="admin.permissions.delete">
            <template #delete-dialog-content>
               <p class="text-muted-foreground text-sm">
                  Are you sure want to delete this <strong>permission</strong>? This action cannot be undone. This will permanently delete the data.
               </p>
            </template>
         </DataTable>
         <EditDialogue v-if="selectedPermission" :permission="selectedPermission" :open="showEditModal" @close="showEditModal = false" />
      </div>
   </AppLayout>
</template>
