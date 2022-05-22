<!doctype html>
<html
    class="{{ Backend::enabled($user, 'dark-mode') ? 'dark' : '' }}"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    {{ $slot }}
</html>
