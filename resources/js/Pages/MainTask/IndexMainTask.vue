<template>
  <div>
    <h1 class="text-xl">現在のタスク一覧</h1>
    <div>
    <div>
      <div @click="createMainTask(props.user)">メインタスクを追加する</div>
    </div>
    <div v-for="maintask in maintasks" :key="maintask.id">
      <div class='mb-4' @click="showMainTask(maintask); showMode = true">
        <button @click.stop="finishMainTask(maintask.id)">完了ボタン</button>
        ID：{{ maintask.id }}　/
        タイトル：{{ maintask.title }}
        <button style="color: red;" @click.stop="deleteTask(maintask.id)">削除</button>
      </div>
    </div>
    </div>
  </div>



  <CreateMainTask v-if="creatingMode && !showMode" :user="editingUser" :statuses="props.taskStatuses" :priorityRanks ='props.priorityRanks'  :errors="props.errors" @create="creatingMode = false"></CreateMainTask>
  <ShowMainTask v-if="showMode && !creatingMode" :statuses="props.taskStatuses" :priorityRanks ='props.priorityRanks' :mainTask = editingMainTask @update="showMainTask"></ShowMainTask>
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
