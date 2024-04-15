<template>
  <Head :title="title" />
  <main>
    <header class="bg-gray-600 h-14 flex items-center px-10">
      <h1 class="text-white text-2xl font-bold">PrimeTask</h1>
      <div class="flex justify-end ms-auto">
        <div v-if="props.user && !props.user.line_id" class="flex justify-center ms-5">
          <Link class="flex justify-center w-full p-3 rounded-sm  bg-green-500 text-white hover:bg-green-600" :href="route('lineLogin')">LINEと連携する</Link>
        </div>
        <div class="flex items-center">
          <p v-if="props.user" class="text-white ms-5">{{ props.user.name }}</p>
        </div>
      </div>
    </header>
    <article>
      <div class="h-screen-minus-14 bg-gray-100 px-10">
      <slot />
      </div>
    </article>
  </main>
</template>

<script setup>
import { Link, Head } from '@inertiajs/vue3'
import { toRefs } from 'vue';
import { Inertia } from '@inertiajs/inertia'
// defineProps({ title: String })

const props = defineProps({
    title: String,
    user:Object
})

const logOut = (userId) => {
  const confirmation = confirm('ユーザーデータを削除しますか？');
  if (confirmation) {
    Inertia.get(`/logOut/${userId}`);
  }
}
</script>

<style>
  * {
    font-family: sans-serif;
  }
  html, body, main {
    height: 100%;
  }
  .h-screen-minus-14 { height: calc(100vh - 3.5rem);}
</style>
