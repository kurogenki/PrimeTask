<template>
<h1>タスクの詳細画面</h1>
<div  v-if="isDetailing && !isEditing">
  <div @click="isEditing = true; isDetailing = false">編集モードへ</div>
  ID: {{ mainTask.id }}
  <br>
  タスク名：{{ mainTask.title }}
  <br>
  優先度：{{ mainTask.priorityRank }}
  <br>
  目的：{{ mainTask.purpose }}
  <br>
  状態：{{ mainTask.status }}
  <br>
  開始日：{{ mainTask.startAt }}
  <br>
  終了日：{{ mainTask.finishAt }}
  <br>
  メモ：{{ mainTask.memo }}
  <br>
</div>

<div v-if="isEditing && !isDetailing">
  <div>編集モード</div>
  <form @submit.prevent="updateMainTask(form.id);">
    タイトル：<input type="text" v-model="form.title">
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
    <br>
    <button>更新</button>
  </form>
  <div @click="isEditing = false; isDetailing = true">詳細モードへ</div>
</div>
    <!-- <Link style="color: blue;" as="button" :href="route('mainTask.index')">メイン画面へ</Link> -->
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { computed, onBeforeUnmount, onMounted, reactive, ref, toRefs, watch } from 'vue';

const props = defineProps({
    mainTask: Object,
    statuses: Array,
    priorityRanks: Array,
})

const { mainTask } = toRefs(props);
console.log(mainTask.value);

const emit = defineEmits(['update']);


const form = reactive({
    id: mainTask.value.id,
    title: mainTask.value.title,
    priorityRank: mainTask.value.priorityRank,
    purpose: mainTask.value.purpose,
    status: mainTask.value.status,
    startAt: mainTask.value.startAt,
    finishAt: mainTask.value.finishAt,
    comment: mainTask.value.comment,
});

const isDetailing = ref(true);
const isEditing = ref(false);
// 他のメインタスクを選ぶ際に、フォームの値を他のメインタスクに更新し、詳細画面を表示する
watch(mainTask, () => {
    form.id = props.mainTask.id
    form.title = props.mainTask.title
    form.priorityRank = props.mainTask.priorityRank,
    form.purpose = props.mainTask.purpose,
    form.status = props.mainTask.status,
    form.startAt = props.mainTask.startAt,
    form.finishAt = props.mainTask.finishAt,
    form.comment = props.mainTask.comment,

    isDetailing.value = true;
    isEditing.value = false;
});

const updateMainTask = mainTaskId => {
    Inertia.put(`/mainTask/${mainTaskId}`, form);
    isEditing.value = false;
    isDetailing.value = true;
    emit('update', form);
}
</script>
