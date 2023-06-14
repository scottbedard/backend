<div class="flex gap-x-3 items-center">
  <div class="aspect-square bg-gray-300/50 flex h-11 items-center justify-center rounded-full">
    <x-backend::icon name="user" />
  </div>
  
  <div class="flex-1">
    <div>
      {{ $model->name }}
    </div>
    
    <div class="text-sm text-gray-600">
      {{ $model->email }}
    </div>
  </div>
</div>
