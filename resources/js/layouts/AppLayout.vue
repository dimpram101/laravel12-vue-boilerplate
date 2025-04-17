<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';

interface Props {
   breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
   breadcrumbs: () => [],
});

const page = usePage<{
   flash: {
      message: string | null;
      success: string | null;
      error: string | null;
   };
}>();

</script>

<template>
   <AppLayout :breadcrumbs="breadcrumbs">
      <template #header-actions>
         <slot name="header-actions" />
      </template>

      <div v-if="page.props.flash && page.props.flash.success" class="mb-4">
         <div class="alert alert-success">
            {{ page.props.flash.success }}
         </div>
      </div>

      <slot />
   </AppLayout>
</template>
