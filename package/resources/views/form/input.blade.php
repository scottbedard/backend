<div class="w-full">
  <label class="font-bold tracking-wide">{{ $options['label'] }}</label>

  <input
    class="border border-gray-300 h-11 px-3 rounded-md w-full"
    type="{{ $type }}"
    @if (array_key_exists('placeholder', $options))
      placeholder="{{ $options['placeholder'] }}"
    @endif

    @if (array_key_exists('max', $options))
      max="{{ $options['max'] }}"
    @endif

    @if (array_key_exists('maxlength', $options))
      maxlength="{{ $options['maxlength'] }}"
    @endif
    
    @if (array_key_exists('min', $options))
      min="{{ $options['min'] }}"
    @endif
    
    @if (array_key_exists('minlength', $options))
      minlength="{{ $options['minlength'] }}"
    @endif
    
    @if (array_key_exists('pattern', $options))
      pattern="{{ $options['pattern'] }}"
    @endif
    
    @if (array_key_exists('placeholder', $options))
      placeholder="{{ $options['placeholder'] }}"
    @endif
    
    @if (array_key_exists('readonly', $options) && $options['readonly'])
      readonly
    @endif

    @if (array_key_exists('required', $options) && $options['required'])
      required
    @endif
    
    @if (array_key_exists('step', $options))
      step="{{ $options['step'] }}"
    @endif
  />
</div>