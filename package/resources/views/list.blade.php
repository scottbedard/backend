<div
  class="h-full"
  id="list-plugin"
></div>

@if (env('BACKEND_DEV'))
<script type="module" src="http://localhost:3000/client/plugins/list/index.ts"></script>
@else
<script type="module" src="{{ asset('vendor/backend/' . $manifest->script('client/plugins/list/index.ts')) }}"></script>
@endif
