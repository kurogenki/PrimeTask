<template>
<h1>タスクの詳細画面</h1>
    <div>
        ID: {{ Props.mainTask.id }}
        <br>
        タスク名：{{ Props.mainTask.title }}
        <br>
        目的：{{ Props.mainTask.purpose }}
    </div>
    <!-- <Link style="color: blue;" as="button" :href="route('mainTask.index')">メイン画面へ</Link> -->
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { onMounted } from 'vue';

const Props = defineProps({
    mainTask: Object
})

</script>
