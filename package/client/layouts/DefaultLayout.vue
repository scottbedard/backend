<template>
  <div class="flex flex-col min-h-screen">
    <header class="border-4 border-red-500 flex justify-between p-6">
      <div>Header</div>

      <div>
        <a href="/logout">Log out</a>
      </div>
    </header>

    <div class="flex flex-1">
      <aside class="border-4 border-blue-500 w-20">
        Hey
      </aside>

      <main class="border-4 border-green-500 flex-1">
        <slot />
      </main>
    </div>
  </div>
</template>
