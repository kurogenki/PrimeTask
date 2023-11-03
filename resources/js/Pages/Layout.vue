<script setup>
import { Link, Head } from '@inertiajs/vue3'
import { toRefs } from 'vue';
// defineProps({ title: String })

const props = defineProps({
    title: String,
    user:Object
})
</script>

<template>
    <Head :title="title" />
    <main>
        <header class="bg-gray-600 h-14 flex items-center px-10">
            <h1 class="text-white text-2xl font-bold">PrimeTask</h1>
        </header>
        <article>
          <div class="h-screen-minus-14 bg-gray-100 px-10">
            <slot />
          </div>
        </article>
    </main>
</template>
<style>
  * {
    font-family: sans-serif;
  }
  html, body, main {
    height: 100%;
  }
  .h-screen-minus-14 { height: calc(100vh - 3.5rem);}
</style>
