<template>
  <div class="flex justify-between p-6">
    <div>
      <RouterLink :to="{ name: 'home' }">Backend title</RouterLink>
    </div>

    <!-- <div>
      <Switch
        v-model="isDark"
        off-icon="sun"
        on-icon="moon"
        :title="`Toggle ${ isDark ? 'light' : 'dark' } mode`" />
    </div> -->
  </div>
</template>

<script lang="ts" setup>
// import { isDark } from '@/app/store/state'
// import { RouterLink } from 'vue-router'
// import { Switch } from '@/components'
</script>