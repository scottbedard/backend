<div class="w-full">
  <label class="font-bold tracking-wide">{{ $field->label }}</label>

  <input
    class="border border-gray-300 h-11 px-3 rounded-md w-full"
    @if ($field->placeholder)
      placeholder="{{ $field->placeholder }}"
    @endif

    @if ($field->max)
      max="{{ $field->max }}"
    @endif

    @if ($field->maxlength)
      maxlength="{{ $field->maxlength }}"
    @endif
    
    @if ($field->min)
      min="{{ $field->min }}"
    @endif
    
    @if ($field->minlength)
      minlength="{{ $field->minlength }}"
    @endif
    
    @if ($field->pattern)
      pattern="{{ $field->pattern }}"
    @endif
    
    @if ($field->placeholder)
      placeholder="{{ $field->placeholder }}"
    @endif
    
    @if ($field->readonly)
      readonly
    @endif

    @if ($field->required)
      required
    @endif
  />
</div>