<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
  <GuestLayout>
    <Head title="Register" />
    <form @submit.prevent="submit" class="m-5">
      <div>
        <InputLabel for="name" value="名前" />
        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name"/>
        <InputError class="mt-2" :message="form.errors.name" />
      </div>
      <div class="mt-4">
        <InputLabel for="email" value="メールアドレス" />
        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username"/>
        <InputError class="mt-2" :message="form.errors.email" />
      </div>
      <div class="mt-4">
        <InputLabel for="password" value="パスワード" />
        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password"/>
        <InputError class="mt-2" :message="form.errors.password" />
      </div>
      <div class="mt-4">
        <InputLabel for="password_confirmation" value="確認用パスワード" />
        <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password"/>
        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>
      <div class="mt-4">
        <Link :href="route('login')"
              class="mt-4 underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          ログイン画面はこちら
        </Link>
      </div>
      <div class="flex justify-center justify-end mt-4">
        <button class="w-full text-white bg-blue-600 border-0 py-2 px-4 focus:outline-none hover:bg-blue-700 rounded" :disabled="form.processing">
          登録
        </button>
      </div>
    </form>
  </GuestLayout>
</template>
