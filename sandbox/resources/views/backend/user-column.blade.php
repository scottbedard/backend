<div class="flex items-center gap-x-2">
  <div class="aspect-square bg-gray-300/50 flex h-8 items-center justify-center rounded-full">
    <x-backend::icon name="user" size="20" />
  </div>
  
  <div class="flex-1">
    <div>
      {{ $model->name }}
    </div>
    
    <div class="text-xs text-gray-600 tracking-wide">
      {{ $model->email }}
    </div>
  </div>
</div>
