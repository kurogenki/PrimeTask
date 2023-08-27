<template>
  <div class="flex">
    <div class="w-3/5 h-full mr-3 p-4 bg-white">
      <h1 class="text-xl">現在のタスク一覧</h1>

      <div class="m-4 py-3 bg-white border-2 rounded flex justify-center hover:bg-blue-500 rounded cursor-pointer"
           @click="createMainTask(props.user)">
        <div>メインタスクを追加する</div>
      </div>
      <hr>
      <div class="h-full overflow-y-scroll" >
        <div v-for="maintask in maintasks" :key="maintask.id">
          <div class='flex m-4 bg-white border-2 rounded cursor-pointer hover:bg-slate-100' @click="showMainTask(maintask); showMode = true">
            <div class="flex flex-col w-2/12 mx-6">
              <!-- タスクのステータスの状態によるラベル -->
              <span v-if="maintask.status === '完了'" class="bg-blue-500">　　</span>
              <span v-else-if="maintask.status === '着手中'" class="bg-green-500">　　</span>
              <span v-else-if="maintask.status === '未着手'" class="bg-red-500">　　</span>
              <!-- <button @click.stop="finishMainTask(maintask.id)">完了ボタン</button> -->
              <input type="checkbox" @click.stop="finishMainTask(maintask.id)">
              <button class="inline-flex items-center justify-center text-white bg-red-600 border-0 py-1 px-2 focus:outline-none hover:bg-red-700 rounded"
              @click.stop="deleteTask(maintask.id)">削除</button>
            </div>

            <p class="w-9/12 font-semibold">タイトル：{{ maintask.title }}</p>
          </div>
        </div>

      </div>
    </div>
    <CreateMainTask v-if="creatingMode && !showMode" :user="editingUser" :statuses="props.taskStatuses" :priorityRanks ='props.priorityRanks'  :errors="props.errors" @create="creatingMode = false"></CreateMainTask>
    <ShowMainTask v-if="showMode && !creatingMode" :statuses="props.taskStatuses" :priorityRanks ='props.priorityRanks' :mainTask = editingMainTask @update="showMainTask"></ShowMainTask>
  </div>
</template>
<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { onMounted, ref, toRefs, watch } from 'vue';
import ShowMainTask from './ShowMainTask.vue';
import CreateMainTask from './CreateMainTask.vue';

const props = defineProps({
    maintasks: Object,
    user: Object,
    taskStatuses: Array,
    priorityRanks: Array,
    errors: Object
});

const { maintasks } = toRefs(props);

const deleteTask = id => {
    Inertia.delete(`/mainTask/${id}`, {
        onBefore: () => confirm('本当に削除しますか?')
    });
}

const creatingMode = ref(false);
const showMode = ref(false);

const editingUser = ref()
const createMainTask = user => {
	showMode.value = false;
	creatingMode.value = true;
	editingUser.value = user;
}

const editingMainTask = ref();
const showMainTask = maintask => {
	creatingMode.value = false;
	showMode.value = true;
	editingMainTask.value = maintask;
}

const finishMainTask = mainTaskId => {
    Inertia.get(`finishMainTask/${mainTaskId}`);
}
</script>
