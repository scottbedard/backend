@if ($label)
    <x-backend::label
        :for="$uid"
        :text="$label"
        :required="$required" />
@endif

<x-backend::input
    :autofocus="$autofocus"
    :disabled="$disabled"
    :id="$uid"
    :name="'form[' . $id . ']'"
    :readonly="$readonly"
    :required="$required"
    :type="$type"
    :value="$value">
</x-backend::input>
