<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { type User } from '@/types/model';
import { Head } from '@inertiajs/vue3';
import HeaderAction from './components/HeaderAction.vue';
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
         <HeaderAction />
      </template>

      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <UserTableList :users="users" />
      </div>
   </AppLayout>
</template>
