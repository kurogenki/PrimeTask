<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="h-screen-minus-14 overflow-scroll">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 pb-10 sm:pt-0 bg-gray-100">
            <div>
                <Link href="/">
                    <ApplicationLogo class="w-48 h-48 fill-current text-gray-500" />
                </Link>
            </div>

            <div
                class="w-full sm:max-w-md mt-6 bg-white shadow-md overflow-hidden sm:rounded-lg"
            >
                <slot />
            </div>
        </div>
    </div>
</template>
<style>
  .h-screen-minus-14 { height: calc(100vh - 3.5rem);}
</style>
