<script lang="ts" setup>
import AppLayout from "@/layouts/AppLayout.vue";
import { User, type BreadcrumbItem } from '@/types';
import { Head } from "@inertiajs/vue3";
import UserTableList from "./components/UserTableList.vue";

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
   users: User[]; // Atau definisikan tipe data yang lebih spesifik jika Anda tahu strukturnya
}>();
</script>

<template>

   <Head title="Users" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <UserTableList :users="users"/>
      </div>
   </AppLayout>
</template>