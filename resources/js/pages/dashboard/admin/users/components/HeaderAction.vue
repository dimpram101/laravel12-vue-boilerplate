<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { EllipsisVertical, UserRoundPlus } from 'lucide-vue-next';
</script>

<template>
   <Button as="a" :href="route('admin.users.create')" variant="outline" size="default"
      class="hidden cursor-pointer items-center gap-2 bg-black text-white sm:flex">
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
               <Button as="a" :href="route('admin.users.create')" variant="ghost" size="sm"
                  class="flex w-full items-center gap-2">
                  <UserRoundPlus :size="24" />
                  <span>Add User</span>
               </Button>
            </DropdownMenuItem>
         </DropdownMenuContent>
      </DropdownMenu>
   </div>
</template>