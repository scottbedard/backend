<div class="w-full">
  <label class="font-bold tracking-wide">{{ $field->label }}</label>

  <x-backend::input
    :autocomplete="$field->autocomplete"
    :autofocus="$field->autofocus"
    :disabled="$field->disabled"
    :max="$field->max"
    :maxlength="$field->maxlength"
    :min="$field->min"
    :minlength="$field->minlength"
    :name="$field->name"
    :pattern="$field->pattern"
    :placeholder="$field->placeholder"
    :readonly="$field->readonly"
    :required="$field->required"
    :type="$field->type"
    :value="$value" />
</div>