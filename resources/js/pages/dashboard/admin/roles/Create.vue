<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import AppLayout from "@/layouts/AppLayout.vue";
import {
   Table,
   TableBody,
   TableHead,
   TableHeader,
   TableRow,
   TableCell
} from '@/components/ui/table';
import { ColumnDef, FlexRender, getCoreRowModel, getPaginationRowModel, useVueTable } from '@tanstack/vue-table';
import { computed, h, ref } from 'vue';
import { BreadcrumbItem, Permission } from "@/types";
import { CreateRoleRequest } from '@/types/formRequests';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, LoaderCircle } from 'lucide-vue-next';

const form = useForm<CreateRoleRequest>({
   name: '',
   permissions: [] as string[],
});

const props = defineProps<{
  permissions: Permission[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
   {
      title: 'Dashboard',
      href: '/dashboard',
   },
   {
      title: 'Roles',
      href: route('admin.roles.index'),
   },
   {
      title: 'Create',
      href: route('admin.roles.create'),
   },
];

const columns: ColumnDef<Permission>[] = [
   {
      accessorKey: 'name',
      header: 'Permission List',
   },
   {
      header: 'Select',
      cell: ({ row }) =>
         h(Checkbox, {
            checked: form.permissions.includes(row.original.name),
            onCheckedChange: (value: boolean) => {
               const permName = row.original.name;
               if (value && !form.permissions.includes(permName)) {
               form.permissions.push(permName);
               } else if (!value) {
               form.permissions = form.permissions.filter(p => p !== permName);
               }
            },
      })
   }
];

const pagination = ref({
   pageIndex: 0,
   pageSize: 15,
});

const table = computed(() => useVueTable({
   data: props.permissions,
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

const submit = () => {
   form.post(route('admin.roles.store'));
};

</script>

<template>

   <Head title="Create Role" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <div class="flex items-center gap-2">
            <Link class="flex items-center gap-2" :href="route('admin.roles.index')">
            <ArrowLeft :size="24" />
            <h1 class="text-2xl font-bold">Create Roles</h1>
            </Link>
         </div>

         <p class="text-muted-foreground text-sm">Fill in the details to create a new roles.</p>

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
                              <TableHead v-for="header in headerGroup.headers" :key="header.id" class="text-bold border-b bg-muted">
                                 {{ header.column.columnDef.header }}
                              </TableHead>
                           </TableRow>
                        </TableHeader>
                        <TableBody>
                           <template v-if="table.getRowModel().rows.length > 0">
                              <TableRow v-for="row in table.getRowModel().rows" :key="row.id" class="h-8">
                                 <template v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <TableCell>
                                       <FlexRender :render="cell.column.columnDef.cell"
                                          :props="{ ...cell.getContext() }" />
                                    </TableCell>
                                 </template>
                              </TableRow>
                           </template>
                           <template v-else>
                              <TableRow>
                                 <TableCell :colspan="columns.length" class="text-center">
                                    No permissions available yet.
                                 </TableCell>
                              </TableRow>
                           </template>
                        </TableBody>
                     </Table>
                     <InputError :message="form.errors.permissions" />
                  </div>
               </div>

               <Button type="submit" class="mt-4 w-full cursor-pointer" :disabled="form.processing">
                  <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin mr-2" />
                  Create Role
               </Button>
            </div>
         </form>
      </div>
   </AppLayout>
</template>