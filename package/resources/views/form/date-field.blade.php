<div class="w-full">
  <label class="font-bold tracking-wide">{{ $field->label }}</label>
  
  <x-backend::datepicker
    :disabled="$field->disabled"
    :format="$field->format"
    :placeholder="$field->placeholder"
    :readonly="$field->readonly"
    :required="$field->required"
    :value="$value" />
</div>
