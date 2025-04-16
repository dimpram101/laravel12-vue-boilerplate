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
      title: 'Roles',
      href: route('admin.roles.index'),
   },
];

</script>

<template>

   <Head title="Roles" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      </div>
   </AppLayout>
</template>