<template>
  <dialog
    class="p-0 rounded-md shadow-2xl"
    ref="dialogEl"
    @click="close">
    
    <div class="gap-6 grid max-w-screen-xs p-6 rounded w-full" @click.stop>
      <p
        v-text="message" />

      <div class="flex justify-end">
        <button
          :class="['backend-btn w-full md:w-auto', {
            'backend-btn-danger': theme === 'danger',
            'backend-btn-default': theme === 'default',
            'backend-btn-primary': theme === 'primary',
          }]"
          @click="$emit('confirm')">
          <Icon
            v-if="icon"
            :name="icon" />

          {{ confirm }}
        </button>
      </div> 
    </div>

  </dialog>
</template>

<script lang="ts" setup>
import { onMounted, ref } from 'vue'
import { ButtonTheme, LucideIcon } from '@/types'
import Icon from './Icon.vue'

const emit = defineEmits<{
  (name: 'close'): void
  (name: 'confirm'): void
}>()

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

function close(e: Event) {
  e.preventDefault()

  emit('close')
}
</script>

<style scoped>
dialog::backdrop {
  @apply bg-gray-500/50;
}
</style>
