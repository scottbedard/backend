<template>
  <a
    href="#"
    class="border border-slate-300 bg-slate-50 flex h-6 items-center justify-center px-3 rounded-full transition-colors w-10 dark:bg-slate-700 dark:border-slate-500 hover:border-slate-400 dark:hover:border-slate-600"
    :title="title"
    @click.prevent="toggle">
    <div class="relative w-full">
      <div
        :class="['absolute bg-white duration-300 flex h-5 items-center justify-center rounded-full text-slate-900 top-1/2 transform -translate-x-1/2 -translate-y-1/2 transition-all w-5 dark:bg-slate-900 dark:text-slate-100',
          modelValue ? 'left-full' : 'left-0'
        ]">
        <transition
          enter-active-class="duration-150 transition-opacity"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="duration-75 transition-opacity"
          leave-from-class="opacity-150"
          leave-to-class="opacity-0"
          mode="out-in">
          <Icon
            v-if="modelValue"
            :name="onIcon"
            :size="4"
            :stroke="1.5" />

          <Icon
            v-else
            :name="offIcon"
            :size="4"
            :stroke="1.5" />
        </transition>
      </div>
    </div>
  </a>
</template>

<script lang="ts" setup>
import { Icon } from '@/components'
import { IconName } from '@/app/icons'

/**
 * Emit
 */
const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void
}>()

/**
 * Props
 */
const props = defineProps<{
  modelValue: boolean
  offIcon: IconName
  onIcon: IconName
  title?: string
}>()

/**
 * Toggle
 */
const toggle = () => {
  emit('update:modelValue', !props.modelValue)
}
</script>
