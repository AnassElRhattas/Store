<template>
  <div class="min-h-screen bg-gray-50 rtl" dir="rtl">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg">
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex-shrink-0">
            <Link href="/" class="flex items-center">
              <img src="/images/logo.png" alt="متجر حميد" class="h-12 w-12 rounded-full object-cover">
              <span class="text-xl font-bold text-gray-800 mr-2">متجر حميد</span>
            </Link>
          </div>

          <!-- Navigation Links -->
          <div class="flex space-x-reverse space-x-8">
            <Link 
              href="/" 
              class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium"
              :class="{ 'text-primary': $page.url === '/' }"
            >
              الرئيسية
            </Link>
            <!-- <Link 
              href="register" 
              class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium"
              :class="{ 'text-primary': $page.url === '/' }"
            >
              تسجيل
            </Link> -->
            <Link 
              href="/products" 
              class="text-gray-600 hover:text-primary px-3 py-2 rounded-md text-sm font-medium"
              :class="{ 'text-primary': $page.url.startsWith('/products') }"
            >
              المنتجات
            </Link>
          </div>

          <!-- Shopping Cart Icon -->
          <div class="flex items-center space-x-reverse space-x-4">
            <Link
              href="/login"
              class="text-gray-600 hover:text-primary p-2"
              title="تسجيل دخول المسؤول"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </Link>
            <button class="text-gray-600 hover:text-primary p-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
      <div class="container mx-auto px-4 text-center">
        <p>© 2024 متجر حميد. جميع الحقوق محفوظة</p>
      </div>
    </footer>
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

/* Define primary colors - matching the existing theme */
:root {
  --color-primary: #3b82f6;
  --color-primary-dark: #2563eb;
}

.text-primary {
  color: var(--color-primary);
}

.hover\:text-primary:hover {
  color: var(--color-primary);
}
</style>
