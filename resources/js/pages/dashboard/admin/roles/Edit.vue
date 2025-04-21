<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Permission } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';
import { computed } from 'vue';
import RoleForm from './components/RoleForm.vue';

const props = defineProps<{
   role: { id: number; name: string; permissions: string[] };
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
      title: 'Edit',
      href: '#',
   },
];

const roleId = computed(() => props.role?.id ?? null);
</script>

<template>
   <Head title="Edit Role" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
         <div class="flex items-center gap-2">
            <Link class="flex items-center gap-2" :href="route('admin.roles.index')">
               <ArrowLeft :size="24" />
               <h1 class="text-2xl font-bold">Edit Role</h1>
            </Link>
         </div>
         <RoleForm
            v-if="roleId"
            :permissions="props.permissions"
            :default-role="props.role"
            :submit-url="route('admin.roles.update', props.role.id)"
            is-edit
         />
      </div>
   </AppLayout>
</template>
