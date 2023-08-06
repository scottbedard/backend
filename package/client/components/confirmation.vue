<template>
  <dialog
    class="gap-6 grid max-w-screen-xs rounded p-6 w-full"
    ref="dialogEl">

    <p
      v-text="message" />

    <div class="flex justify-end">
      <button
        :class="['backend-btn', {
          'backend-btn-danger': theme === 'danger',
          'backend-btn-default': theme === 'default',
          'backend-btn-primary': theme === 'primary',
        }]">
        <Icon
          v-if="icon"
          :name="icon" />

        {{ confirm }}
      </button>
    </div>
  </dialog>
</template>

<script lang="ts" setup>
import { computed, onMounted, ref } from 'vue'
import { ButtonTheme, LucideIcon } from '@/types'
import Icon from './Icon.vue'

const props = defineProps<{
  confirm: string
  icon: LucideIcon | null
  message: string
  theme: ButtonTheme
}>()

const dialogEl = ref<HTMLDialogElement>()

onMounted(() => {
  dialogEl.value?.showModal()
})
</script>
