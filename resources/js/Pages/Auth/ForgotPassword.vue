<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
  <GuestLayout>
    <Head title="Forgot Password" />
    <div class="m-5">
      <div class="mb-4 text-sm text-gray-600">
      パスワードをお忘れの方はご自身のメールアドレスを入力してください。<br>
      パスワードのリセットメールをお送りします。
      </div>
      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
      </div>
      <form @submit.prevent="submit">
        <div>
          <InputLabel for="email" value="メールアドレス" />
          <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username"/>
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="flex items-center justify-end mt-4">
          <button class="w-full text-white bg-blue-600 border-0 py-2 px-4 focus:outline-none hover:bg-blue-700 rounded" :disabled="form.processing">
            パスワードリセットメールを送信
          </button>
        </div>
      </form>
    </div>
  </GuestLayout>
</template>
