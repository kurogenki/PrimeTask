<script setup>
import { Link, Head } from '@inertiajs/vue3'
defineProps({ title: String })
</script>

<template>
    <Head :title="title" />
    <main>
        <header class="bg-blue-400 h-14 flex items-center px-10">
            <h1 class="text-2xl font-bold">PrimeTask</h1>
            <!-- <div href="{{route('linelogin')}}">LINEログイン</div> -->
            <Link :href="route('linelogin')">LINEにログインする</Link>
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
