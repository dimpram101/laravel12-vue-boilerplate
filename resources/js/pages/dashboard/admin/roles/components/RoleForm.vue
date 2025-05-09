<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Permission } from '@/types';
import { CreateRoleRequest } from '@/types/formRequests';
import { useForm } from '@inertiajs/vue3';
import { ColumnDef, FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table';
import { LoaderCircle } from 'lucide-vue-next';
import { h } from 'vue';

const props = defineProps<{
   permissions: Permission[];
   submitUrl: string;
   defaultRole?: {
      name: string;
      permissions: string[];
   };
   isEdit?: boolean;
}>();

const form = useForm<CreateRoleRequest>({
   name: props.defaultRole?.name || '',
   permissions: props.defaultRole?.permissions || [],
});

const columns: ColumnDef<Permission>[] = [
   {
      accessorKey: 'name',
      header: 'Permission List',
   },
   {
      header: 'Select',
      cell: ({ row }) =>
         h(Checkbox, {
            modelValue: form.permissions!.includes(row.original.name),
            'onUpdate:modelValue': (value: boolean | 'indeterminate') => {
               if (value === 'indeterminate') return;
               const permName = row.original.name;
               if (value && !form.permissions!.includes(permName)) {
                  form.permissions!.push(permName);
               } else if (!value) {
                  form.permissions = form.permissions!.filter((p) => p !== permName);
               }
            },
         }),
   },
];

const table = useVueTable({
   data: props.permissions,
   columns,
   getCoreRowModel: getCoreRowModel(),
});

const submit = () => {
   if (props.isEdit) {
      form.put(props.submitUrl, {
         preserveScroll: true,
      });
   } else {
      form.post(props.submitUrl, {
         preserveScroll: true,
      });
   }
};
</script>

<template>
   <form @submit.prevent="submit" class="flex flex-col gap-6">
      <div class="grid gap-6">
         <div class="grid gap-2">
            <Label for="name">Role Name</Label>
            <Input id="name" v-model="form.name" placeholder="e.g. Editor" />
            <InputError :message="form.errors.name" />
         </div>

         <div class="grid gap-2">
            <Label>Permissions</Label>
            <div class="rounded-md border">
               <Table>
                  <TableHeader>
                     <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id" class="text-bold bg-muted border-b">
                           {{ header.column.columnDef.header }}
                        </TableHead>
                     </TableRow>
                  </TableHeader>
                  <TableBody>
                     <template v-if="table.getRowModel().rows.length > 0">
                        <TableRow v-for="row in table.getRowModel().rows" :key="row.id" class="h-8">
                           <template v-for="cell in row.getVisibleCells()" :key="cell.id">
                              <TableCell>
                                 <FlexRender :render="cell.column.columnDef.cell" :props="{ ...cell.getContext() }" />
                              </TableCell>
                           </template>
                        </TableRow>
                     </template>
                     <template v-else>
                        <TableRow>
                           <TableCell :colspan="columns.length" class="text-center"> No permissions available yet. </TableCell>
                        </TableRow>
                     </template>
                  </TableBody>
               </Table>
               <InputError :message="form.errors.permissions" />
            </div>
         </div>

         <Button type="submit" class="mt-4 w-full cursor-pointer" :disabled="form.processing">
            <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
            {{ isEdit ? 'Update Role' : 'Create Role' }}
         </Button>
      </div>
   </form>
</template>
