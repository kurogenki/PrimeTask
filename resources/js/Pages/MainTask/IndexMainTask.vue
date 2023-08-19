<template>
  <div>
    <h1 class="text-xl">現在のタスク一覧</h1>
    <div>
    <!-- <Link as="button" method="get" :href="route('mainTask.create', {id: user.id})">新規作成画面へ</Link> -->
    <div>
      <div @click="createMainTask(Props.user)">メインタスクを追加する</div>
    </div>
    <div v-for="maintask in Props.maintasks" :key="maintask.id">
      <div class='mb-4' @click="showMainTask(maintask); showMode = true">
          ID：{{ maintask.id }}　/
          タイトル：{{ maintask.title }}
          <button style="color: red;" @click.stop="deleteTask(maintask.id)">削除</button>
      </div>
    </div>

    </div>

  </div>



  <CreateMainTask v-if="creatingMode" :user="editingUser" :errors="Props.errors"></CreateMainTask>
  <ShowMainTask v-if="showMode" :mainTask = editingMainTask></ShowMainTask>
</template>
<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from 'vue';
import ShowMainTask from './ShowMainTask.vue';
import CreateMainTask from './CreateMainTask.vue';

const Props = defineProps({
    maintasks: Object,
    user: Object,
    errors: Object
});


const deleteTask = id => {
    Inertia.delete(`/mainTask/${id}`, {
        onBefore: () => confirm('本当に削除しますか?')
    });
}

// const isRendered = ref(true);
// onMounted(() => {
//   if (isRendered.value) {
//     isRendered.value = false;
//   }
// });

const creatingMode = ref(false);

const editingUser = ref()
const createMainTask = user => {
  creatingMode.value = true;
  editingUser.value = user;
}

const showMode = ref(false);
const editingMainTask = ref();
const showMainTask = maintask => {
  editingMainTask.value = maintask;
    // showMode.value = true;
    // console.log(editingMainTask.value);
    // Inertia.get(`/mainTask/${id}`)
}


</script>
