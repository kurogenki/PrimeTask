<template>
    新規作成画面
    <!-- <div>{{ Props.user.email }}</div> -->

    <form @submit.prevent="createMainTask">
    <br>
    タイトル：<input type="text" v-model="form.title">
    <div v-if="Props.errors.title">{{ Props.errors.title }}</div>
    <br>
    <!-- 優先度：<input type="text" v-model="newPriorityRank"> -->
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

const Props = defineProps({
    user: Object,
    errors: Object
})

// const newTitle = ref()

const form = reactive({
  id: Props.user.id,
  title: null,
  purpose: null ,
  startAt: null,
  finishAt: null,
  memo: null,
})

const createMainTask = userId => {
 Inertia.post(`/mainTask/${userId}`, form);
}


const deleteTask = id => {
    Inertia.delete(`/mainTask/${id}`, {
        onBefore: () => confirm('本当に削除しますか?')
    });
}


</script>
