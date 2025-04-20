<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Role } from '@/types';
import { Head } from '@inertiajs/vue3';
import HeaderAction from './components/HeaderAction.vue';
import RoleTableList from './components/RoleTableList.vue';

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

defineProps<{
   roles: Role[];
}>();
</script>

<template>
   <Head title="Roles" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <template #header-actions>
         <HeaderAction />
      </template>

      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <RoleTableList :roles="roles" />
      </div>
   </AppLayout>
</template>
