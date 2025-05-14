<template>
  <ClientLayout>
    <div class="space-y-8">
      <!-- Page Title -->
      <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900">المنتجات</h1>
      </div>

      <!-- Products Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div v-for="product in products" :key="product.id" class="bg-white rounded-lg shadow-md overflow-hidden">
          <!-- Product Image -->
          <div class="aspect-w-3 aspect-h-2">
            <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover">
          </div>

          <!-- Product Info -->
          <div class="p-4 space-y-2">
            <h2 class="text-xl font-semibold text-gray-900">{{ product.name }}</h2>
            <p class="text-gray-600 text-sm line-clamp-2">{{ product.description }}</p>
            <div class="flex justify-between items-center mt-4">
              <span class="text-lg font-bold text-primary">{{ product.price }} درهم</span>
              <button 
                class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition-colors"
                :disabled="product.stock === 0"
              >
                {{ product.stock > 0 ? 'أضف إلى السلة' : 'نفذت الكمية' }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- No Products Message -->
      <div v-if="!products.length" class="text-center py-12">
        <p class="text-gray-600 text-lg">لا توجد منتجات متاحة حالياً</p>
      </div>
    </div>
  </ClientLayout>
</template>

<script setup>
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { defineProps } from 'vue';

defineProps({
  products: {
    type: Array,
    required: true
  }
});
</script>