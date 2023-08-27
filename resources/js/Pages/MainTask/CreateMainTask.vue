<template>
    <div>メインタスクの作成</div>
    <form @submit.prevent="createMainTask">
        　　改行
    <br>
    タイトル：<input type="text" v-model="form.title">
    <div v-if="props.errors.title">{{ props.errors.title }}</div>
    <br>
    優先度：<select v-model="form.priorityRank">
              <option value=""></option>
              <option v-for="priorityRank in props.priorityRanks" :key="priorityRank">{{ priorityRank }}</option>
            </select>
    <br>
    目的：<input type="text" v-model="form.purpose">
    <br>
    状態：<select v-model="form.status">
            <option value=""></option>
            <option v-for="status in props.statuses" :key="status">{{ status }}</option>
          </select>
    <br>
    開始日：<input type="date" v-model="form.startAt">
    <br>
    終了日：<input type="date" v-model="form.finishAt">
    <br>
    メモ：<textarea type="text" v-model="form.memo"></textarea>
    <br>
    <button>formタグの保存ボタン</button>
    </form>


    <!-- <Link as="button" method="post" :href="route('mainTask.store', {id: user.id})"
    :data="{
        userId: user.id,
        title: newTitle
    }">保存</Link> -->

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
  priorityRank: null,
  purpose: null ,
  status: null,
  startAt: null,
  finishAt: null,
  memo: null,
})

const createMainTask = () => {
 Inertia.post(`/mainTask`, form);
 emit('create')
}
</script>
