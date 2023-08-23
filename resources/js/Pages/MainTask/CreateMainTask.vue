<template>
    新規作成画面
    <form @submit.prevent="createMainTask">
    <br>
    タイトル：<input type="text" v-model="form.title">
    <div v-if="props.errors.title">{{ props.errors.title }}</div>
    <br>
    状態：<select v-model="form.status">
        <option value=""></option>
        <option v-for="status in props.statuses" :key="status">{{ status }}</option>
    </select>
    目的：<input type="text" v-model="form.purpose">
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
    errors: Object
})

const emit = defineEmits(['create']);

const form = reactive({
  id: props.user.id,
  title: null,
  purpose: null ,
  status: null,
  startAt: null,
  finishAt: null,
  memo: null,
})

const createMainTask = userId => {
 Inertia.post(`/mainTask/${userId}`, form);
 emit('create')
 form.title = null;
 form.purpose = null;
 form.startAt = null;
}
</script>
