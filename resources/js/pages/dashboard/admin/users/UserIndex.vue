<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import AppLayout from '@/layouts/AppLayout.vue';
import { User, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { EllipsisVertical, UserRoundPlus } from 'lucide-vue-next';
import UserTableList from './components/UserTableList.vue';

const breadcrumbs: BreadcrumbItem[] = [
   {
      title: 'Dashboard',
      href: '/dashboard',
   },
   {
      title: 'Users',
      href: route('admin.users'),
   },
];

defineProps<{
   users: User[];
}>();
</script>

<template>
   <Head title="Users" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <template #header-actions>
         <Button
            as="a"
            :href="route('admin.roles.index')"
            variant="outline"
            size="default"
            class="hidden cursor-pointer items-center gap-2 bg-black text-white sm:flex"
         >
            <UserRoundPlus :size="4" />
            <span>Add User</span>
         </Button>

         <div class="sm:hidden">
            <DropdownMenu>
               <DropdownMenuTrigger as-child>
                  <EllipsisVertical :size="16" class="text-muted-foreground cursor-pointer" />
               </DropdownMenuTrigger>
               <DropdownMenuContent class="w-40" align="start">
                  <DropdownMenuItem>
                     <Button as="a" :href="route('admin.roles.index')" variant="ghost" size="sm" class="flex w-full items-center gap-2">
                        <UserRoundPlus :size="24" />
                        <span>Add User</span>
                     </Button>
                  </DropdownMenuItem>
               </DropdownMenuContent>
            </DropdownMenu>
         </div>
      </template>

      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <UserTableList :users="users" />
      </div>
   </AppLayout>
</template>
