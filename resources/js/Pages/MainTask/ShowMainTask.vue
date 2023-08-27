<template>
<!-- <div class="h-screen-minus-14 overflow-y-screen">
  <div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div><div>a</div>
</div> -->
  <div class="w-2/5 h-full bg-blue-500 p-8 overflow-y-scroll">
    <div class="block" v-if="isDetailing && !isEditing">
      <div @click="isEditing = true; isDetailing = false">編集する</div>
      <h3 class="text-2xl font-bold">{{ mainTask.title }}</h3>
      <div class="flex">
        <div class="w-1/2">
          <!-- <p class="h-20">目的：</p> -->
          <div>優先度：</div>
          <p>状態：</p>
          <p>開始日：</p>
          <p>終了日</p>
        </div>
        <div class="w-1/2">
          <!-- <div class="h-20 mx-auto border-2 overflow-y-scroll break-words">{{ mainTask.purpose }}</div> -->
          <div>{{ mainTask.priority_rank }}</div>
          <p>{{ mainTask.status }}</p>
          <p>{{ mainTask.start_at }}</p>
          <p>{{ mainTask.finish_at }}</p>
        </div>
      </div>
      <div class="flex">
        <p class="w-1/4">目的</p>
        <div class="w-3/4 h-20 mx-auto border-2 overflow-y-scroll break-words">{{ mainTask.purpose }}</div>
      </div>

      メモ：<div class="h-80 mx-auto border-2 overflow-y-scroll break-words">{{ mainTask.memo }}</div>

    </div>

    <div v-if="isEditing && !isDetailing">
      <div @click="isEditing = false; isDetailing = true">詳細を見る</div>
      <form @submit.prevent="updateMainTask(form.id);">
        タイトル：<input type="text" v-model="form.title">
        <br>
        優先度：<select v-model="form.priorityRank">
                <option value=""></option>
                <option v-for="priorityRank in props.priorityRanks" :key="priorityRank">{{ priorityRank }}</option>
                </select>
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
        <div class="flex justify-center">
          <p class="w-1/5">目的</p>
          <textarea type="text" v-model="form.purpose"></textarea>
        </div>

        <br>
        メモ：<textarea type="text" v-model="form.memo" class="w-4/5 h-80 mx-auto border-2"></textarea>
        <br>
        <br>
        <div class="flex justify-center">
          <button class="inline-flex text-white bg-blue-600 border-0 py-2 px-4 focus:outline-none hover:bg-blue-700 rounded">更新</button>
        </div>
      </form>
    </div>
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

const emit = defineEmits(['update']);


const form = reactive({
    id: mainTask.value.id,
    title: mainTask.value.title,
    priorityRank: mainTask.value.priorityRank,
    purpose: mainTask.value.purpose,
    status: mainTask.value.status,
    startAt: mainTask.value.startAt,
    finishAt: mainTask.value.finishAt,
    memo: mainTask.value.memo,
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
<style>
  .h-screen-minus-14 { height: calc(100vh - 3.5rem);}
</style>
