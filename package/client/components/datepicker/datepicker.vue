<template>
  <div
    v-if="visible"
    class="absolute bg-white border border-gray-300 gap-3 max-w-xs my-3 p-3 right-0 rounded-md text-sm w-full"
    key="days">

    <!-- days -->
    <div
      v-if="screen === Screen.Days"
      class="gap-2 grid grid-cols-7">
      <button
        class="flex h-8 items-center justify-center rounded-md hover:bg-gray-100"
        @click="cursorDate = addMonths(cursorDate, -1)">
        <Icon size="18" :name="ChevronLeft" />
      </button>
    
      <div class="col-span-5 flex justify-center ">
        <button
          v-text="format(cursorDate, 'MMMM yyyy')"
          class="h-8 tracking-wide px-3 rounded-md hover:bg-gray-100"
          @click="screen = Screen.Months" />
      </div>

      <button
        class="flex h-8 items-center justify-center rounded-md hover:bg-gray-100"
        @click="cursorDate = addMonths(cursorDate, 1)">
        <Icon size="18" :name="ChevronRight" />
      </button>

      <button
        v-for="day in calendarDays"
        v-text="format(day, 'd')"
        :class="['flex h-8 items-center justify-center rounded-md text-center hover:bg-gray-100', {
          'text-gray-400 hover:text-gray-500': day < cursorMonthStart || day > cursorMonthEnd,
          'bg-primary-100 hover:bg-primary-200': startOfDay(day).getTime() === startOfDay(currentDate).getTime(),
        }]"
        :data-date="day"
        @click="currentDate = day" />
    </div>

    <!-- month -->
    <div
      v-else-if="screen === Screen.Months"
      class="gap-2 grid grid-cols-4"
      key="months">
      <div class="col-span-4 gap-2 grid grid-cols-7">
        <button
          class="flex h-8 items-center justify-center rounded-md hover:bg-gray-100"
          @click="cursorDate = addYears(cursorDate, -1)">
          <Icon size="18" :name="ChevronLeft" />
        </button>
      
        <div class="col-span-5 flex justify-center ">
          <button
            v-text="format(cursorDate, 'yyyy')"
            class="h-8 tracking-wide px-3 rounded-md hover:bg-gray-100"
            @click.prevent="screen = Screen.Days" />
        </div>

        <button
          class="flex h-8 items-center justify-center rounded-md hover:bg-gray-100"
          @click="cursorDate = addYears(cursorDate, 1)">
          <Icon size="18" :name="ChevronRight" />
        </button>
      </div>

      <button
        v-for="n in 12"
        v-text="format(addMonths(startOfYear(cursorDate), n - 1), 'MMM')"
        class="h-8 tracking-wide px-3 rounded-md hover:bg-gray-100"
        @click="setCursorMonth(n - 1)" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { addDays, addMonths, addYears, differenceInDays, endOfMonth, endOfWeek, format, getHours, getMinutes, getSeconds, parse, setHours, setMinutes, setMonth, setSeconds, startOfDay, startOfMonth, startOfWeek, startOfYear } from 'date-fns'
import { ChevronLeft, ChevronRight } from 'lucide'
import { computed, ref } from 'vue'
import { datetime } from '@/utils'
import { range } from 'lodash-es'
import { useEventListener } from '@vueuse/core'
import Icon from '@/components/Icon.vue'

const props = defineProps<{
  targetEl: HTMLElement
}>()

// datepicker screen
enum Screen {
  Days,
  Months,
}

const screen = ref(Screen.Days)

// input element
const inputEl = computed(() => props.targetEl.querySelector('input'))

// visibility toggle
const visible = ref(false)

// current date
const _currentDate = ref(parse(datetime(inputEl.value?.value), 'yyyy-MM-dd hh:mm:ss', new Date()))

const currentDate = computed({
  get() {
    return _currentDate.value
  },
  set(d: Date) {
    const inputEl = props.targetEl.querySelector('input')

    if (inputEl) {
      inputEl.value = format(d, 'yyyy-MM-dd hh:mm:ss')
    }

    _currentDate.value = d
  },
})

// cursor date values
const cursorDate = ref(currentDate.value)

const cursorMonthStart = computed(() => startOfMonth(cursorDate.value))

const cursorMonthEnd = computed(() => endOfMonth(cursorDate.value))

const calendarDays = computed(() => {
  const from = startOfWeek(startOfMonth(cursorDate.value))

  const to = addDays(endOfWeek(endOfMonth(cursorDate.value)), 1)

  const h = getHours(cursorDate.value)
  const m = getMinutes(cursorDate.value)
  const s = getSeconds(cursorDate.value)

  return range(differenceInDays(to, from))
    .map((n: number) => setSeconds(setMinutes(setHours(addDays(from, n), h), m), s))
})

// setter utils
const setCursorMonth = (month: number) => {
  cursorDate.value = setMonth(cursorDate.value, month)
  screen.value = Screen.Days
}

// show events
useEventListener(props.targetEl, 'mousedown', () => {
  if (visible.value) {
    return
  }

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
