<script setup>
import { Link, Head } from '@inertiajs/vue3'
defineProps({ title: String })
</script>

<template>
    <Head :title="title" />
    <main>
        <header class="bg-blue-400 h-14 flex items-center px-10">
            <h1 class="text-2xl">PrimeTask</h1>
            <!-- <div class="flex w-auto">
              <Link href="/" class="underline m-2">Home</Link>
              <Link :href="route('mainTask.index')" class="underline m-2">メインタスク一覧</Link>
            </div> -->
        </header>
        <div class="h-screen-minus-14 bg-gray-100 px-10">
          <div class="h-full">
            <article>
            <slot />

          </article>
          </div>
        </div>
    </main>
</template>
<style>
html, body, main {
  height: 100%;
}
  .h-screen-minus-14 { height: calc(100vh - 3.5rem);}
</style>
