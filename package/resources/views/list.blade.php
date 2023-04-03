<div class="border-4 border-danger-500 border-dashed p-6">
  Hello from a list!
</div>

@if (env('BACKEND_DEV'))
  <script type="module" src="http://localhost:3000/client/plugins/list.ts"></script>
@endenv