<template>
  <div>
    <SidebarLink
      v-for="(resource, index) in resources"
      :active="resource.class === currentResource?.class"
      :icon="resource.icon"
      :key="index"
      :text="resource.title"
      :to="{
        name: 'resource',
        params: {
          route: resource.route,
        },
      }" />

    <SidebarLink
      v-if="isSuper"
      icon="shield-check"
      text="Administrators"
      :active="routeParam === 'administrators'"
      :to="'#'" />
  </div>
</template>

<script lang="ts" setup>
import { isSuper } from '@/app/store/computed'
import { useResourceByRoute, useRouteParam } from '@/app/behaviors'
import SidebarLink from '@/partials/layout/SidebarLink.vue'

/**
 * Resources
 */
const { resources } = window.context

/**
 * Route param
 */
const routeParam = useRouteParam('route')

/**
 * Current resource
 */
const currentResource = useResourceByRoute(routeParam)
</script>