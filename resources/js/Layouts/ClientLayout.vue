<template>
  <div dir="rtl">
    <div class="min-h-screen bg-gray-100">
      <nav class="border-b border-gray-100 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 justify-between">
            <div class="flex">
              <!-- Logo -->
              <div class="flex shrink-0 items-center">
                <Link href="/" class="flex items-center">
                  <img src="/images/logo.png" alt="متجر حميد" class="h-9 w-auto rounded-full object-cover">
                  <span class="text-xl font-bold text-gray-800 mr-2">متجر حميد</span>
                </Link>
              </div>
            </div>

            <div class="hidden sm:ms-6 sm:flex sm:items-center gap-4">
              <Link
                href="/login"
                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                title="تسجيل الدخول"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span class="mr-2">دخول المشرف</span>
              </Link>
            </div>
          </div>
        </div>
      </nav>

      <!-- Main Content -->
      <main class="w-full">
        <slot />
      </main>

      <!-- Footer -->
      <footer class="bg-gray-800 text-white py-8 w-full">
        <div class="w-full px-4 text-center">
          <p>© 2024 متجر حميد. جميع الحقوق محفوظة</p>
        </div>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<style scoped>
.rtl {
  direction: rtl;
  text-align: right;
}
</style>
