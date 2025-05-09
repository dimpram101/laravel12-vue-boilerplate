<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Role } from '@/types';
import { CreateUserRequest } from '@/types/formRequests';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, LoaderCircle } from 'lucide-vue-next';

const form = useForm<CreateUserRequest>({
   name: '',
   email: '',
   password: '',
   role: '',
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
      title: 'Create',
      href: route('admin.users'),
   },
];

defineProps<{
   roles: Role[];
}>();

const submit = () => {
   form.post(route('admin.users.store'));
};
</script>

<template>

   <Head title="Create User" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <div class="flex items-center gap-2">
            <Link class="flex items-center gap-2" :href="route('admin.users')">
            <ArrowLeft :size="24" />
            <h1 class="text-2xl font-bold">Create User</h1>
            </Link>
         </div>

         <p class="text-muted-foreground text-sm">Fill in the details to create a new user.</p>

         <!-- User creation form goes here -->
         <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid grid-cols-2 gap-6">
               <div class="grid gap-2">
                  <Label for="name">Name</Label>
                  <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.name"
                     placeholder="Full name" />
                  <InputError :message="form.errors.name" />
               </div>

               <div class="grid gap-2">
                  <Label for="email">Email address</Label>
                  <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email"
                     placeholder="email@example.com" />
                  <InputError :message="form.errors.email" />
               </div>

               <div class="grid gap-2">
                  <Label for="password">Password</Label>
                  <Input id="password" type="password" required :tabindex="3" autocomplete="new-password"
                     v-model="form.password" placeholder="Password" />
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

               <Button type="submit" class="col-span-2 mt-2 w-full cursor-pointer" tabindex="5"
                  :disabled="form.processing">
                  <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                  Create account
               </Button>
            </div>
         </form>
      </div>
   </AppLayout>
</template>
