<template>
  <div class="w-2/5 h-screen-minus-14 overflow-y-scroll">
    <div class="my-3 p-4 bg-white">
      <div class="text-3xl font-extrabold">メインタスクの作成</div>
      <form @submit.prevent="createMainTask">
        <div class="w-11/12 mx-auto my-3">
          <p class="font-semibold">タイトル</p>
          <div class="flex justify-center">
            <textarea type="text" class="w-4/5 h-28 mx-auto font-semibold border-2" v-model="form.title"></textarea>
          </div>
        </div>
        <div v-if="props.errors.title">{{ props.errors.title }}</div>
        <div class="my-3">
          優先度：<select v-model="form.priority_rank">
                    <option value=""></option>
                    <option v-for="priorityRank in props.priorityRanks" :key="priorityRank">{{ priorityRank }}</option>
                  </select>
        </div>
        <div class="my-3">
          状態：<select v-model="form.status">
                  <option value=""></option>
                  <option v-for="status in props.statuses" :key="status">{{ status }}</option>
                </select>
        </div>
        <div class="my-3">
          開始日：<input type="date" v-model="form.start_day">
        </div>
        <div class="my-3">
          終了日：<input type="date" v-model="form.finish_day">
        </div>
        <div class="flex justify-center">
          <p class="w-12">目的</p>
          <textarea type="text" v-model="form.purpose"></textarea>
        </div>
        <div class="w-11/12 my-3 mx-auto">
          <p>メモ</p>
          <div class="flex justify-center">
            <textarea type="text"  class="h-64 border-2" v-model="form.memo"></textarea>
          </div>
        </div>
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
