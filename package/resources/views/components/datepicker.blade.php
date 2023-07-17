<div
  class="group relative"
  data-backend-datepicker>
  <x-backend::input
    class="cursor-pointer"
    :disabled="isset($disabled) ? (bool) $disabled : false"
    :placeholder="isset($placeholder) ? $placeholder : null"
    :readonly="true"
    :required="isset($required) ? (bool) $required : false"
    :value="$value" />

  <x-backend::icon
    class="absolute cursor-pointer right-3 text-gray-400 top-1/2 -translate-y-1/2 group-hover:text-gray-500"
    name="calendar"
    size="20" />
</div>
