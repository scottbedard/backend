<div
  class="relative"
  data-backend-datepicker-format="{{ isset($format) ? $format : '' }}"
  data-backend-datepicker="{{ $value->toDateTimeString() }}">
  <x-backend::input
    :disabled="isset($disabled) ? (bool) $disabled : false"
    :placeholder="isset($placeholder) ? $placeholder : null"
    :readonly="isset($readonly) ? (bool) $readonly : false"
    :required="isset($required) ? (bool) $required : false" />
</div>
