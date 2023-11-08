<template>
  <div class="flex h-screen-minus-14">
    <div class="w-3/5 h-full overflow-y-scroll">
      <div class="my-3 mr-3 p-4 bg-white">
        <div class="flex">
          <h1 class="mx-4 my-2 text-3xl font-extrabold w-3/4">現在のタスク一覧</h1>
          <div class="flex justify-end w-full">
            <div class="flex items-center mx-3">
              <input type="checkbox" id="未着手" v-model="statuses.未着手" class="mx-1 focus:ring-0"/>
              <label for="未着手" class="bg-blue-100 px-2">未着手</label>
            </div>
            <div class="flex items-center mx-3">
              <input type="checkbox" id="着手中" v-model="statuses.着手中" class="mx-1 focus:ring-0"/>
              <label for="着手中" class="bg-red-100 px-2">着手中</label>
            </div>
            <div class="flex items-center mx-3">
              <input type="checkbox" id="完了" v-model="statuses.完了" class="mx-1 focus:ring-0"/>
              <label for="完了" class="bg-green-100 px-2">完了</label>
            </div>
          </div>
        </div>
        <div class="m-4 py-3 text-blue-600 font-semibold bg-white border-2 rounded flex justify-center hover:bg-gray-100 rounded cursor-pointer"
              @click="createMainTask(props.user)">
          <div>メインタスクを追加する</div>
        </div>
        <hr>
        <div v-for="maintask in filteredTasks" :key="maintask.id">
          <div class='flex m-4 bg-white border-2 rounded cursor-pointer hover:bg-slate-100' @click="showMainTask(maintask); showMode = true">
            <div class="flex flex-col justify-center items-center w-2/12 mx-6">
              <!-- タスクのステータスの状態によるラベル -->
              <span v-if="maintask.status === '完了'" class="flex justify-center w-full my-1 bg-green-100">完了</span>
              <span v-else-if="maintask.status === '着手中'" class="flex justify-center w-full my-1 bg-red-100">着手中</span>
              <span v-else-if="maintask.status === '未着手'" class="flex justify-center w-full my-1 bg-blue-100">未着手</span>
              <!-- <button @click.stop="finishMainTask(maintask.id)">完了ボタン</button> -->
              <input type="checkbox" class="my-1" @click.stop="finishMainTask(maintask.id)">
              <button class="inline-flex items-center justify-center text-white my-1 py-1 px-2 bg-gray-600 border-0focus:outline-none hover:bg-red-700 rounded"
              @click.stop="deleteTask(maintask.id)">削除</button>
            </div>
            <p class="mt-8 w-9/12 font-semibold">{{ maintask.title }}</p>
          </div>
        </div>
      </div>
    </div>
    <CreateMainTask v-if="creatingMode && !showMode"
                  :user="editingUser"
                  :statuses="props.taskStatuses"
                  :priorityRanks ='props.priorityRanks'
                  :errors="props.errors"
                  @create="creatingMode = false">
    </CreateMainTask>
    <ShowMainTask v-if="showMode && !creatingMode"
                    :statuses="props.taskStatuses"
                    :priorityRanks ='props.priorityRanks'
                    :mainTask = editingMainTask
                    @update="showMainTask">
    </ShowMainTask>
  </div>
</template>
<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { computed, onMounted, ref, toRefs, watch } from 'vue';
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
// 新しくメインタスクを登録する
const createMainTask = user => {
	showMode.value = false;
	creatingMode.value = true;
	editingUser.value = user;
}

// 選択されたタスクの詳細を表示する
const editingMainTask = ref();
const showMainTask = maintask => {
	creatingMode.value = false;
	showMode.value = true;
	editingMainTask.value = maintask;
}

// 完了ボタンを押した際に、ステータスを変更し、終了日を登録する
const finishMainTask = mainTaskId => {
    Inertia.get(`finishMainTask/${mainTaskId}`);
}

//表示するタスクのステータスを選択する
const statuses = ref({
  未着手: true,
  着手中: true,
  完了: true,
})

const filteredTasks = computed(() => {
  return maintasks.value.filter((task) => {
    return statuses.value[task.status]
  })
})
</script>
<style>
  .h-screen-minus-14 { height: calc(100vh - 3.5rem);}
</style>
