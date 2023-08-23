<template>
<h1>タスクの詳細画面</h1>
<div  v-if="isDetailing && !isEditing">
    <div @click="isEditing = true; isDetailing = false">編集モードへ</div>
        ID: {{ mainTask.id }}
        <br>
        タスク名：{{ props.mainTask.title }}
        <br>
        目的：{{ mainTask.purpose }}
    </div>

    <div v-if="isEditing && !isDetailing">
        <div>編集モード</div>
        <form @submit.prevent="updateMainTask(form.id);">
          タイトル：<input type="text" v-model="form.title">
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
    mainTask: Object
})

const { mainTask } = toRefs(props);

const emit = defineEmits(['update']);


const form = reactive({
    id: mainTask.value.id,
    title: mainTask.value.title,
});

const isDetailing = ref(true);
const isEditing = ref(false);
// 他のメインタスクを選ぶ際に、フォームの値を他のメインタスクに更新し、詳細画面を表示する
watch(mainTask, () => {
    form.id = props.mainTask.id
    form.title = props.mainTask.title

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
