<div class="w-full">
  <label class="font-bold tracking-wide">{{ $field->get('label') }}</label>

  <input
    class="border border-gray-300 h-11 px-3 rounded-md w-full"
    @if ($field->get('placeholder'))
      placeholder="{{ $field->get('placeholder') }}"
    @endif

    @if ($field->get('max'))
      max="{{ $field->get('max') }}"
    @endif

    @if ($field->get('maxlength'))
      maxlength="{{ $field->get('maxlength') }}"
    @endif
    
    @if ($field->get('min'))
      min="{{ $field->get('min') }}"
    @endif
    
    @if ($field->get('minlength'))
      minlength="{{ $field->get('minlength') }}"
    @endif
    
    @if ($field->get('pattern'))
      pattern="{{ $field->get('pattern') }}"
    @endif
    
    @if ($field->get('placeholder'))
      placeholder="{{ $field->get('placeholder') }}"
    @endif
    
    @if ($field->get('readonly', $field))
      readonly
    @endif

    @if ($field->get('required'))
      required
    @endif
  />
</div>