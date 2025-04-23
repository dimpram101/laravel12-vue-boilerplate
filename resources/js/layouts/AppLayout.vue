<script setup lang="ts">
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType, SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { AlertCircle, CheckCircle, LucideMessageCircle } from 'lucide-vue-next';

interface Props {
   breadcrumbs?: BreadcrumbItemType[];
   message?: string | null;
}

withDefaults(defineProps<Props>(), {
   breadcrumbs: () => [],
});

const props = usePage<SharedData>().props;
</script>

<template>
   <AppLayout :breadcrumbs="breadcrumbs">
      <template #header-actions>
         <slot name="header-actions" />
      </template>

      <div v-if="props.flash">
         <div v-if="props.flash.message || message" class="pt-4 px-4">
            <Alert class="bg-black font-bold text-white">
               <LucideMessageCircle class="h-4 w-4" />
               <AlertTitle>Message</AlertTitle>
               <AlertDescription class="font-semibold text-white">
                  {{ props.flash.message || message }}
               </AlertDescription>
            </Alert>
         </div>
         <div v-if="props.flash.success" class="pt-4 px-4">
            <Alert class="bg-green-400 font-bold text-white">
               <CheckCircle class="h-4 w-4" />
               <AlertTitle>Success</AlertTitle>
               <AlertDescription class="font-semibold text-white">
                  {{ props.flash.success }}
               </AlertDescription>
            </Alert>
         </div>
         <div v-if="props.flash.error" class="pt-4 px-4">
            <Alert class="bg-red-700 font-bold text-white">
               <AlertCircle class="h-4 w-4" />
               <AlertTitle>Error</AlertTitle>
               <AlertDescription class="font-semibold text-white">
                  {{ props.flash.error }}
               </AlertDescription>
            </Alert>
         </div>
      </div>

      <slot />
   </AppLayout>
</template>
