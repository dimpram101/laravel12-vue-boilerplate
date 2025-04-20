<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { type Table } from '@tanstack/vue-table';
import { ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight } from 'lucide-vue-next';

interface DataTablePaginationProps<T> {
   table: Table<T>;
   pageSizes?: number[];
   label?: string;
}

defineProps<DataTablePaginationProps<any>>();
</script>

<template>
   <div class="flex items-center justify-center sm:justify-end">
      <div class="flex flex-col items-center sm:flex-row lg:space-x-8">
         <!-- Rows per page -->
         <div class="flex items-center space-x-2">
            <p class="text-sm font-medium">{{ label || 'Rows per page' }}</p>
            <Select :model-value="`${table.getState().pagination.pageSize}`" @update:model-value="(value) => table.setPageSize(Number(value))">
               <SelectTrigger class="h-8 w-[70px]">
                  <SelectValue :placeholder="`${table.getState().pagination.pageSize}`" />
               </SelectTrigger>
               <SelectContent side="top">
                  <SelectItem v-for="pageSize in pageSizes || [10, 15, 20, 25, 50, 100]" :key="pageSize" :value="`${pageSize}`">
                     {{ pageSize }}
                  </SelectItem>
               </SelectContent>
            </Select>
         </div>

         <!-- Pagination buttons -->
         <div class="mt-2 flex flex-row items-center space-x-2 sm:mt-0 sm:space-x-4">
            <div class="flex w-[100px] items-center justify-center text-sm font-medium">
               Page {{ table.getState().pagination.pageIndex + 1 }} of {{ table.getPageCount() }}
            </div>

            <div class="flex items-center space-x-2">
               <!-- First -->
               <Button variant="outline" class="hidden h-8 w-8 p-0 lg:flex" :disabled="!table.getCanPreviousPage()" @click="table.setPageIndex(0)">
                  <span class="sr-only">Go to first page</span>
                  <ChevronsLeft class="h-4 w-4" />
               </Button>

               <!-- Prev -->
               <Button variant="outline" class="h-8 w-8 p-0" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()">
                  <span class="sr-only">Go to previous page</span>
                  <ChevronLeft class="h-4 w-4" />
               </Button>

               <!-- Next -->
               <Button variant="outline" class="h-8 w-8 p-0" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
                  <span class="sr-only">Go to next page</span>
                  <ChevronRight class="h-4 w-4" />
               </Button>

               <!-- Last -->
               <Button
                  variant="outline"
                  class="hidden h-8 w-8 p-0 lg:flex"
                  :disabled="!table.getCanNextPage()"
                  @click="table.setPageIndex(table.getPageCount() - 1)"
               >
                  <span class="sr-only">Go to last page</span>
                  <ChevronsRight class="h-4 w-4" />
               </Button>
            </div>
         </div>
      </div>
   </div>
</template>
