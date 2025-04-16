<script lang="ts" setup>
import AppLayout from "@/layouts/AppLayout.vue";
import { BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/vue3";

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

</script>

<template>
   <!-- Create dan Edit dialogue jadiin satu aja di halaman ini -->

   <Head title="Permissions" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      </div>
   </AppLayout>
</template>