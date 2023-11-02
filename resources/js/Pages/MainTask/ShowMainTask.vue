<template>
  <div class="w-2/5 h-full overflow-y-scroll">
    <div class="my-3 p-4 bg-white">
      <div class="block" v-if="isDetailing && !isEditing">
        <div class="inline-flex text-white bg-green-600 border-0 py-2 px-4 focus:outline-none hover:bg-green-700 rounded"
             @click="isEditing = true; isDetailing = false">編集する</div>
        <h3 class="text-2xl font-bold">{{ mainTask.title }}</h3>
        <div class="flex">
          <div class="w-1/2">
            <div class="my-3">優先度：</div>
            <div class="my-3">状態：</div>
            <div class="my-3">開始日：</div>
            <div class="my-3">終了日：</div>
          </div>
          <div class="w-1/2">
            <div class="my-3">{{ mainTask.priority_rank ? mainTask.priority_rank : '　' }}</div>
            <div class="my-3">{{ mainTask.status ? mainTask.status : '　' }}</div>
            <div class="my-3">{{ mainTask.start_day ? mainTask.start_day : '　' }}</div>
            <div class="my-3">{{ mainTask.finish_day ? mainTask.finish_day : '　' }}</div>
          </div>
        </div>
        <div class="flex justify-center items-center my-3">
          <p class="w-1/4">目的：</p>
          <div class="w-3/4 h-20 mx-auto border-2 overflow-y-scroll break-words">{{ mainTask.purpose }}</div>
        </div>
        <hr>
        <div class="my-3">
          <p class="w-1/4">メモ</p>
          <div class="h-80 mx-auto border-2 overflow-y-scroll break-words">{{ mainTask.memo }}</div>
        </div>
      </div>

      <!-- 更新用Vue -->
      <div v-if="isEditing && !isDetailing">
        <div class="inline-flex text-white bg-green-600 border-0 py-2 px-4 my-3 focus:outline-none hover:bg-green-700 rounded"
             @click="isEditing = false; isDetailing = true">詳細を見る</div>
        <form @submit.prevent="updateMainTask(form.id);">
          <div class="w-11/12 mx-auto">
            <p class="font-semibold">タイトル</p>
            <div class="flex justify-center">
              <textarea type="text" class="w-4/5 h-28 mx-auto font-semibold border-2" v-model="form.title"></textarea>
            </div>
          </div>
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
              <textarea type="text" v-model="form.memo" class="h-64 border-2"></textarea>
            </div>
          </div>
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
