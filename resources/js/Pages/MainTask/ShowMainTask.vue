<template>
  <div class="w-2/5 h-full overflow-y-scroll">
    <div class="my-3 p-4 bg-white">
      <div class="block mx-4" v-if="isDetailing && !isEditing">
        <div class="flex justify-end" @click="isEditing = true; isDetailing = false">
          <div class=" text-white bg-blue-500 border-0 py-2 px-4 my-3 focus:outline-none hover:bg-blue-600 rounded">編集する</div>
        </div>
        <h3 class="my-3 text-2xl font-bold">{{ mainTask.title }}</h3>
        <hr>
        <div class="flex">
          <div class="w-1/2">
            <div class="my-4">優先度：</div>
            <div class="my-4">状態：</div>
            <div class="my-4">開始日：</div>
            <div class="my-4">終了日：</div>
          </div>
          <div class="w-1/2">
            <div class="my-4">{{ mainTask.priority_rank ? mainTask.priority_rank : '　' }}</div>
            <div class="my-4">{{ mainTask.status ? mainTask.status : '　' }}</div>
            <div class="my-4">{{ mainTask.start_day ? mainTask.start_day : '　' }}</div>
            <div class="my-4">{{ mainTask.finish_day ? mainTask.finish_day : '　' }}</div>
          </div>
        </div>
        <p class="mt-5 mb-2">目的</p>
        <div class="h-20 mb-5 border-2 overflow-y-scroll break-words">{{ mainTask.purpose }}</div>
        <hr>
        <div class="my-4">
          <p class="w-1/4 mb-2">メモ</p>
          <div class="h-80 mx-auto border-2 overflow-y-scroll break-words">{{ mainTask.memo }}</div>
        </div>
      </div>

      <!-- 更新用Vue -->
      <div v-if="isEditing && !isDetailing" class="mx-4">
        <div class="flex justify-end"
             @click="isEditing = false; isDetailing = true">
             <div class=" text-white bg-blue-500 border-0 py-2 px-4 my-3 focus:outline-none hover:bg-blue-600 rounded">詳細を見る</div>
        </div>
        <form @submit.prevent="updateMainTask(form.id);">
          <div class="border-b-2">
            <input type="text" class="w-full text-2xl font-bold border-0 focus:ring-0" v-model="form.title" required>
          </div>
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
          <textarea class="w-full mb-5 border-2" v-model="form.purpose" placeholder="目的を書く" cols="42" rows="4"></textarea>
          <hr>
          <p class="mt-5 mb-1">メモ</p>
          <textarea class="w-full mb-5 border-2" v-model="form.memo" placeholder="メモを書く" cols="42" rows="10"></textarea>
          <div class="flex justify-center">
            <button class="inline-flex text-white bg-blue-600 border-0 py-2 px-4 focus:outline-none hover:bg-blue-700 rounded">更新</button>
          </div>
        </form>
      </div>
    </div>
  </div>
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
    priority_rank: mainTask.value.priority_rank,
    purpose: mainTask.value.purpose,
    status: mainTask.value.status,
    start_day: mainTask.value.start_day,
    finish_day: mainTask.value.finish_day,
    memo: mainTask.value.memo,
});

const isDetailing = ref(true);
const isEditing = ref(false);
// 他のメインタスクを選ぶ際に、フォームの値を他のメインタスクに更新し、詳細画面を表示する
watch(mainTask, () => {
    form.id = props.mainTask.id
    form.title = props.mainTask.title
    form.priority_rank = props.mainTask.priority_rank,
    form.purpose = props.mainTask.purpose,
    form.status = props.mainTask.status,
    form.start_day = props.mainTask.start_day,
    form.finish_day = props.mainTask.finish_day,
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
