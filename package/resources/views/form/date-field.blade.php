<div class="w-full">
  <label class="font-bold tracking-wide">{{ $field->label }}</label>
  
  <x-backend::datepicker
    :disabled="$field->disabled"
    :placeholder="$field->placeholder"
    :readonly="$field->readonly"
    :required="$field->required"
    :value="$value" />
</div>
