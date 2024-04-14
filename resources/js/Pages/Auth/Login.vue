<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />
    <div class="m-5">
      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
          {{ status }}
      </div>
      <form @submit.prevent="submit">
        <div class="my-2">
          <InputLabel for="email" value="メールアドレス" />
          <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username"/>
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="my-8">
          <InputLabel for="password" value="パスワード" />
          <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password"/>
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        <div class="block mt-4">
          <label class="flex items-center">
            <Checkbox name="remember" v-model:checked="form.remember" />
            <span class="ml-2 text-sm text-gray-600">ログイン状態を保存する</span>
          </label>
        </div>
        <div class="mt-4">
          <Link :href="route('register')" class="ml-4 font-solid text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            ユーザー登録画面はこちら
          </Link>
        </div>
        <!-- TODO パスワードリセット機能
        <div class="mt-4">
          <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            パスワードをお忘れの方はこちら
          </Link>
        </div> -->
        <div class="mt-4 mb-4">
          <button class="w-full text-white bg-blue-600 border-0 py-2 px-4 focus:outline-none hover:bg-blue-700 rounded">ログイン</button>
        </div>
      </form>
      <div class="flex justify-center">
        <Link class="flex justify-center w-full py-3 bg-green-500 text-white hover:bg-green-600" :href="route('lineLogin')">LINEログイン</Link>
      </div>
    </div>
  </GuestLayout>
</template>
