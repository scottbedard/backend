<!doctype html>
<html
    class="{{ Backend::enabled(Auth::user(), 'dark-mode') ? 'dark' : '' }}"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    {{ $slot }}
</html>
