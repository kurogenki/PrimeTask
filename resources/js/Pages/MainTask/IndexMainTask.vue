<template>
    <h1>現在のタスク一覧</h1>
    <Link as="button" method="get" :href="route('mainTask.create', {id: user.id})">新規作成画面へ</Link>
    <div v-for="maintask in maintasks" :key="maintask.id">
      <div>
          <div>タイトル：{{ maintask.title }}</div>
      </div>
      <div>ユーザーID：{{ user.id }}</div>
    </div>



</template>
<script setup>
// import { Link } from '@inertiajs/vue3';
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    maintasks: Array,
    user: Array
});


</script>
