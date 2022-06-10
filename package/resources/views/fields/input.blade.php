<x-backend::form-field
    :label="$label"
    :required="$required">
    
    <x-backend::input
        :autofocus="$autofocus"
        :disabled="$disabled"
        :placeholder="$placeholder"
        :readonly="$readonly"
        :required="$required"
        :type="$type"
        :value="$value" />
</x-backend::form-field>