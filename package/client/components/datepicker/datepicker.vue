<template>
  <div
    v-if="visible"
    class="absolute border border-gray-300 gap-3 max-w-xs my-3 p-3 right-0 rounded-md w-full">

    <!-- days -->
    <div v-if="screen === Screen.Days">
      <div class="gap-2 grid grid-cols-7 text-sm">
        <button class="backend-btn-transparent flex h-8 items-center justify-center rounded-md hover:bg-gray-100">
          <Icon size="18" :name="ChevronLeft" />
        </button>
      
        <div class="col-span-5 flex justify-center ">
          <button
            v-text="format(cursorDate, 'MMMM')"
            class="backend-btn-transparent h-8 tracking-wide px-3 rounded-md hover:bg-gray-100"
            @click="screen = Screen.Months" />
        </div>

        <button class="backend-btn-transparent flex h-8 items-center justify-center rounded-md hover:bg-gray-100">
          <Icon size="18" :name="ChevronRight" />
        </button>

        <button
          v-for="day in calendarDays"
          v-text="format(day, 'd')"
          :class="['backend-btn-transparent flex h-8 items-center justify-center rounded-md text-center hover:bg-gray-100', {
            'text-gray-400 hover:text-gray-500': day < cursorMonthStart || day > cursorMonthEnd,
          }]" />
      </div>
    </div>

    <!-- month -->
    <div v-else-if="screen === Screen.Months">
      Month!
    </div>
  </div>
</template>

<script lang="ts" setup>
import { addDays, differenceInDays, endOfMonth, endOfWeek, format, parse, startOfMonth, startOfWeek } from 'date-fns'
import { ChevronLeft, ChevronRight } from 'lucide'
import { computed, ref } from 'vue'
import { datetime } from '@/utils'
import { range } from 'lodash-es'
import { useEventListener } from '@vueuse/core'
import Icon from '@/components/Icon.vue'

const props = defineProps<{
  targetEl: HTMLElement,
}>()

// datepicker screen
enum Screen {
  Days,
  Months,
  Years,
}

const screen = ref(Screen.Days)

// visibility toggle
const visible = ref(false)

// input value and date object
const currentDatetime = computed({
  get() {
    return datetime(props.targetEl.dataset.backendDatepicker)
  },
  set(val: string) {
    const inputEl = props.targetEl.querySelector('input')

    if (inputEl) {
      // ...
    }
  },
})

const currentDate = computed(() => {
  return parse(currentDatetime.value, 'yyyy-MM-dd hh:mm:ss', new Date())
})

// cursor date values
const cursorDate = ref(currentDate.value)

const cursorMonthStart = computed(() => startOfMonth(cursorDate.value))

const cursorMonthEnd = computed(() => endOfMonth(cursorDate.value))

const calendarDays = computed(() => {
  const from = startOfWeek(startOfMonth(cursorDate.value))

  const to = addDays(endOfWeek(endOfMonth(cursorDate.value)), 1)

  return range(differenceInDays(to, from)).map((n: number) => addDays(from, n))
})

// show events
useEventListener(props.targetEl, 'mousedown', () => {
  screen.value = Screen.Days
  visible.value = true
})

// hide events
useEventListener(document.body, 'mousedown', (e: Event) => {
  for (const el of e.composedPath()) {
    if (el === props.targetEl) {
      return
    }
  }

  visible.value = false
})
</script>
