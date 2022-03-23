<template>
  <div>
    <ResourceNotFound
      v-if="!resource"
      :route-param="routeParam" />

    <div v-else>
      <pre>{{ { resource } }}</pre>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { useResourceByRoute, useRouteParam } from '@/app/behaviors'
import ResourceNotFound from '@/partials/resource/ResourceNotFound.vue'

/**
 * Route param
 */
const routeParam = useRouteParam('route')

/**
 * Resource
 */
const resource = useResourceByRoute(routeParam)
</script>
