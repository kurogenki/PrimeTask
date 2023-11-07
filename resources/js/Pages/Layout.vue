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

<template>
    <Head :title="title" />
    <main>
        <header class="bg-gray-600 h-14 flex items-center px-10">
            <h1 class="text-white text-2xl font-bold">PrimeTask</h1>
            <button v-if="props.user && props.user.line_id" class="text-end ml-auto text-gray-200 hover:text-gray-500" @click="logOut(props.user.id)">ユーザーを削除する</button>
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
