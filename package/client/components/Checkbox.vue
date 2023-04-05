<template>
  <div class="be-checkbox">
    <input
      type="checkbox"
      :id="id"
      :checked="modelValue"
      :disabled="disabled"
      :required="required"
      @change="onChange" />

    <label :for="id">
      <slot />
    </label>
  </div>
</template>

<script lang="ts" setup>
import { uniqueId } from 'lodash-es'

const emit = defineEmits<{
  (e: 'update:modelValue', checked: boolean): void
}>()

const props = withDefaults(defineProps<{
  dataCheckbox?: string
  disabled?: boolean
  label?: string
  id?: string
  modelValue?: boolean
  required?: boolean
  sublabel?: string
}>(), {
  id: () => uniqueId('be-checkbox-'),
})


const onChange = (e: Event) => {
  emit('update:modelValue', (e.target as HTMLInputElement).checked)
}
</script>

<style lang="scss">
.be-checkbox input[type="checkbox"] {
  // take out of the document and hide it
  @apply absolute opacity-0 pointer-events-none;

  & + label {
    @apply cursor-pointer flex items-center gap-x-2 p-0 relative tracking-wide;
  }

  // box
  & + label:before {
    content: '';
    @apply align-text-top bg-gray-50 border border-gray-300 h-6 inline-block rounded-md w-6;
  }

  &:not(:disabled):hover + label:before {
    @apply border-gray-400;
  }

  &:checked + label:before {
    // @apply bg-primary-500 border-0;
  }
  
  // disabled
  &:disabled + label {
    cursor: auto;
  }

  // checkmark
  &:checked + label:after {
    --size: 2.5px;
    box-shadow:
      var(--size) 0 0 currentColor,
      calc(var(--size) * 2) 0 0 currentColor,
      calc(var(--size) * 2) calc(var(--size) * -1) 0 currentColor,
      calc(var(--size) * 2) calc(var(--size) * -2) 0 currentColor,
      calc(var(--size) * 2) calc(var(--size) * -3) 0 currentColor,
      calc(var(--size) * 2) calc(var(--size) * -4) 0 currentColor;
    content: '';
    height: var(--size);
    left: 5px;
    position: absolute;
    top: 11px;
    transform: rotate(45deg);
    width: var(--size);

    @apply bg-current text-primary-500;
  }
}
</style>
