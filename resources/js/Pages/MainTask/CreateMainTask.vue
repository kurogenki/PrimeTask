<template>
  <div class="w-2/5 h-screen-minus-14 overflow-y-scroll">
    <div class="my-3 p-4 bg-white">
      <form @submit.prevent="createMainTask">
        <div class="mt-4">
          <div class="border-b-2">
            <input type="text" class="w-full text-2xl font-bold border-0 focus:ring-0" v-model="form.title" placeholder="タスクのタイトルを書く" required>
          </div>
        </div>
        <div v-if="props.errors.title" class="my-2 text-red-600">{{ props.errors.title }}</div>
        <div class="my-4">
          <label>優先度：</label>
          <select class="border-2 ml-1" v-model="form.priority_rank">
            <option value=""></option>
            <option v-for="priorityRank in props.priorityRanks" :key="priorityRank">{{ priorityRank }}</option>
          </select>
        </div>
        <div class="my-4">
          <label class="ml-2">状態：</label>
          <select class="border-2 ml-1" v-model="form.status">
            <option v-for="status in props.statuses" :key="status">{{ status }}</option>
          </select>
        </div>
        <div class="my-4">
          <label>開始日：</label>
          <input type="date" class="border-2 ml-1" v-model="form.start_day">
        </div>
        <div class="my-4">
          <label>終了日：</label>
          <input type="date" class="border-2 ml-1" v-model="form.finish_day">
        </div>
        <p class="mt-5 mb-1">目的</p>
        <textarea class="mb-5 border-2" v-model="form.purpose" placeholder="目的を書く" cols="42" rows="4"></textarea>
        <hr>
        <p class="mt-5 mb-1">メモ</p>
        <textarea class="mb-5 border-2" v-model="form.memo" placeholder="メモを書く" cols="42" rows="10"></textarea>
        <div class="flex justify-center my-2">
          <button class="inline-flex text-white bg-blue-600 border-0 py-2 px-4 focus:outline-none hover:bg-blue-700 rounded">保存</button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    statuses: Array,
    priorityRanks: Array,
    errors: Object
})

const emit = defineEmits(['create']);

const form = reactive({
  id: props.user.id,
  title: null,
  priority_rank: null,
  purpose: null ,
  status: null,
  start_day: null,
  finish_day: null,
  memo: null,
})

const createMainTask = () => {
 Inertia.post(`/mainTask`, form);
 emit('create')
}
</script>
<style>
  .h-screen-minus-14 { height: calc(100vh - 3.5rem);}
</style>
