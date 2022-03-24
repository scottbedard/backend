<template>
  <div class="flex flex-col min-h-screen">
    <Header />

    <div class="border-t border-slate-200 flex flex-1 dark:border-slate-700">
      <div class="border-r-0 border-slate-200 duration-300 overflow-hidden relative transition-[width] w-0 sm:border-r sm:w-16 lg:w-1/5 2xl:w-1/6 dark:border-slate-700">
        <Sidebar />
      </div>

      <div class="flex-1">
        <Content />
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import Content from '@/layout/Content.vue'
import Header from '@/layout/Header.vue'
import Sidebar from '@/layout/Sidebar.vue'
</script>
