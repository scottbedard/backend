<x-backend::form-field
    :label="$field->label ?: $field->id"
    :required="$field->required">
    
    <x-backend::input
        :autofocus="$field->autofocus"
        :disabled="$field->disabled"
        :placeholder="$field->placeholder"
        :readonly="$field->readonly"
        :required="$field->required"
        :type="$field->type"
        :value="$field->value" />
</x-backend::form-field>