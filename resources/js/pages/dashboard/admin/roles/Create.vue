<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Permission } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import RoleForm from './components/RoleForm.vue';

const props = defineProps<{
   permissions: Permission[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
   { title: 'Dashboard', href: '/dashboard' },
   { title: 'Roles', href: route('admin.roles.index') },
   { title: 'Create', href: route('admin.roles.create') },
];
</script>

<template>
   <Head title="Create Role" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <div class="flex items-center gap-2">
            <Link class="flex items-center gap-2" :href="route('admin.roles.index')">
               <ArrowLeft :size="24" />
               <h1 class="text-2xl font-bold">Create Role</h1>
            </Link>
         </div>

         <p class="text-muted-foreground text-sm">Fill in the details to create a new roles.</p>

         <RoleForm :permissions="props.permissions" :submit-url="route('admin.roles.store')" />
      </div>
   </AppLayout>
</template>
