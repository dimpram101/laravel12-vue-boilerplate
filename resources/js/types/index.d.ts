import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';
export * from './model';

export interface Auth {
   user: User;
   is_admin: boolean;
}

export interface BreadcrumbItem {
   title: string;
   href: string;
}

export interface NavItem {
   title: string;
   href: string;
   icon?: LucideIcon;
   isActive?: boolean;
}

export interface SharedData extends PageProps {
   name: string;
   auth: Auth;
   ziggy: Config & { location: string };
   sidebarOpen: boolean;
   flash: {
      message: string | null;
      success: string | null;
      error: string | null;
   };
}

export type BreadcrumbItemType = BreadcrumbItem;

export type Role = {
   permissions: Permission[];
   id: number;
   name: string;
   guardname: string;
   permission: Permission[];
};

export type Permission = {
   id: number;
   name: string;
};
