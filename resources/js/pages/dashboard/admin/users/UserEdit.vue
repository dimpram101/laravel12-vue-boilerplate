<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Permission, Role, User } from '@/types';
import { UpdateUserRequest } from '@/types/formRequests';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ColumnDef, FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table';
import { ArrowLeft, LoaderCircle } from 'lucide-vue-next';
import { h } from 'vue';

const props = defineProps<{
   roles: Role[];
   user: User;
   permissions: Permission[];
}>();

const user = props.user as User;
console.log(user);

const form = useForm<UpdateUserRequest>({
   name: user.name,
   email: user.email,
   password: '',
   role: user.roles.length > 0 ? user.roles[0].name : '',
   permissions: user.permissions ? user.permissions.map((p: Permission) => p.name) : [],
});

const breadcrumbs: BreadcrumbItem[] = [
   {
      title: 'Dashboard',
      href: '/dashboard',
   },
   {
      title: 'Users',
      href: route('admin.users'),
   },
   {
      title: 'Edit',
      href: route('admin.users'),
   },
];

const submit = () => {
   form.put(route('admin.users.update', user.id), {
      preserveScroll: true,
      onSuccess: () => {
         form.reset('password');
      },
   });
};

console.log(props)

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
</script>

<template>
   <Head title="Edit User" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <div class="flex items-center gap-2">
            <Link class="flex items-center gap-2" :href="route('admin.users')">
               <ArrowLeft :size="24" />
               <h1 class="text-2xl font-bold">Edit User</h1>
            </Link>
         </div>

         <p class="text-muted-foreground text-sm">Fill in the details to edit the user.</p>

         <!-- User creation form goes here -->
         <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid grid-cols-2 gap-6">
               <div class="grid gap-2">
                  <Label for="name">Name</Label>
                  <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.name" placeholder="Full name" />
                  <InputError :message="form.errors.name" />
               </div>

               <div class="grid gap-2">
                  <Label for="email">Email address</Label>
                  <Input
                     disabled
                     id="email"
                     type="email"
                     required
                     :tabindex="2"
                     autocomplete="email"
                     v-model="form.email"
                     placeholder="email@example.com"
                  />
                  <InputError :message="form.errors.email" />
               </div>

               <div class="grid gap-2">
                  <Label for="password">Password</Label>
                  <Input id="password" type="password" :tabindex="3" autocomplete="new-password" v-model="form.password" placeholder="Password" />
                  <InputError :message="form.errors.password" />
               </div>

               <div class="grid gap-2">
                  <Label for="role">Role</Label>
                  <Select name="role" id="role" v-model="form.role" :tabindex="4" placeholder="Select a role">
                     <SelectTrigger class="w-full">
                        <SelectValue :placeholder="'Select a role'" />
                     </SelectTrigger>
                     <SelectContent side="top">
                        <SelectItem v-for="role in roles" :key="role.id" :value="role.name">
                           {{ role.name }}
                        </SelectItem>
                     </SelectContent>
                  </Select>
                  <InputError :message="form.errors.role" />
               </div>

               <div class="grid col-span-2 gap-2">
                  <Label>Direct Permissions</Label>
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

               <Button type="submit" class="col-span-2 mt-2 w-full cursor-pointer" tabindex="5" :disabled="form.processing">
                  <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                  Edit account
               </Button>
            </div>
         </form>
      </div>
   </AppLayout>
</template>
