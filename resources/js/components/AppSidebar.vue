<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Bolt, BookCheck, BookOpen, Folder, LayoutGrid, User } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: { [key: string]: NavItem[] } = {
   admin: [
      {
         title: 'Users',
         href: route('admin.users'),
         icon: User,
      },
      {
         title: 'Roles',
         href: route('admin.roles.index'),
         icon: Bolt,
      },
      {
         title: 'Permissions',
         href: route('admin.permissions.index'),
         icon: BookCheck,
      },
   ],
   general: [
      {
         title: 'Dashboard',
         href: route('dashboard'),
         icon: LayoutGrid,
      },
   ],
}

const footerNavItems: NavItem[] = [
   {
      title: 'Github Repo',
      href: 'https://github.com/laravel/vue-starter-kit',
      icon: Folder,
   },
   {
      title: 'Documentation',
      href: 'https://laravel.com/docs/starter-kits',
      icon: BookOpen,
   },
];
</script>

<template>
   <Sidebar collapsible="icon" variant="inset">
      <SidebarHeader>
         <SidebarMenu>
            <SidebarMenuItem>
               <SidebarMenuButton size="lg" as-child>
                  <Link :href="route('dashboard')">
                  <AppLogo />
                  </Link>
               </SidebarMenuButton>
            </SidebarMenuItem>
         </SidebarMenu>
      </SidebarHeader>

      <SidebarContent>
         <NavMain :items="mainNavItems.general" label="General" />
         <NavMain :items="mainNavItems.admin" label="Admin" />
      </SidebarContent>

      <SidebarFooter>
         <NavFooter :items="footerNavItems" />
         <NavUser />
      </SidebarFooter>
   </Sidebar>
   <slot />
</template>
