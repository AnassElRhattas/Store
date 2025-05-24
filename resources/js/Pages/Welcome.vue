<template>
  <ClientLayout>
    <div class="min-h-screen bg-white">
      <!-- Hero Section -->
      <div class="relative h-[600px] overflow-hidden">
        <div class="absolute inset-0">
          <img src="/images/store_image.jpg" alt="Store Background" class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-black/50"></div>
        </div>
        <div class="relative h-full flex items-center">
          <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
              <h1 class="text-6xl font-bold text-white mb-6">متجر حميد</h1>
              <p class="text-2xl text-white/90 mb-8">تسوق بسهولة واحصل على أفضل المنتجات</p>
              <div class="relative max-w-xl mx-auto">
                <input 
                  type="search"
                  placeholder="ابحث عن منتجاتك المفضلة..."
                  class="w-full px-6 py-4 rounded-lg text-lg bg-white/95 backdrop-blur-sm border-0 focus:ring-2 focus:ring-green-500"
                >
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Categories Section -->
      <div class="container mx-auto px-4 -mt-20 relative z-10 mb-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100">
                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-gray-900">منتجات جديدة</h3>
                <p class="text-gray-600 text-sm">اكتشف أحدث المنتجات</p>
              </div>
            </div>
          </div>

          <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-full bg-yellow-100">
                <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-gray-900">الأكثر مبيعاً</h3>
                <p class="text-gray-600 text-sm">المنتجات المفضلة</p>
              </div>
            </div>
          </div>

          <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100">
                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-gray-900">عروض خاصة</h3>
                <p class="text-gray-600 text-sm">تخفيضات حصرية</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Products Section -->
      <div class="mb-16 p-4">
        <div class="flex justify-between items-center mb-12">
          <h2 class="text-4xl font-bold text-gray-900">منتجاتنا المميزة</h2>
          <button 
            @click="openOrderForm"
            :disabled="selectedProducts.length === 0"
            class="px-8 py-4 bg-blue-900 text-white text-lg rounded-full hover:bg-blue-800 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl"
          >
            طلب المنتجات ({{ selectedProducts.length }})
          </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
          <div v-for="product in products" :key="product.id" 
               class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 border border-gray-100">
            <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
              <img :src="'/storage/' + product.image" :alt="product.name" 
                   class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              <div class="absolute top-4 left-4 z-10">
                <input 
                  type="checkbox" 
                  :value="product.id"
                  v-model="selectedProducts"
                  class="w-6 h-6 rounded-full border-2 border-blue-500 text-blue-600 focus:ring-blue-500 cursor-pointer"
                ></div>
                <div class="absolute bottom-4 right-4 z-10">
                  <span class="px-4 py-2 rounded-full text-sm font-medium bg-white/90 text-gray-900">
                    {{ product.stock > 0 ? 'متوفر' : 'نفذ المخزون' }}
                  </span>
                </div>
              </div>

              <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ product.name }}</h3>
                <p class="text-gray-600 mb-4 line-clamp-2">{{ product.description }}</p>
                <div class="flex items-center justify-between">
                  <span class="text-2xl font-bold text-blue-900">{{ product.price }} درهم</span>
                  <span class="text-sm bg-blue-50 text-blue-900 px-3 py-1 rounded-full">المخزون: {{ product.stock }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order Form Modal -->
      <div v-if="showOrderForm" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl">
          <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900">معلومات الطلب</h2>
            <button @click="showOrderForm = false" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
              <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <form @submit.prevent="submitOrder" class="space-y-8">
            <div class="space-y-6">
              <div>
                <label class="block text-lg font-medium text-gray-700 mb-3">الاسم</label>
                <input type="text" v-model="orderForm.first_name" required
                       class="w-full px-6 py-4 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg">
              </div>
              <div>
                <label class="block text-lg font-medium text-gray-700 mb-3">اللقب</label>
                <input type="text" v-model="orderForm.last_name" required
                       class="w-full px-6 py-4 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg">
              </div>
              <div>
                <label class="block text-lg font-medium text-gray-700 mb-3">رقم الهاتف</label>
                <input type="tel" v-model="orderForm.phone" required
                       class="w-full px-6 py-4 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg">
              </div>
              <div>
                <label class="block text-lg font-medium text-gray-700 mb-3">العنوان</label>
                <textarea v-model="orderForm.address" required rows="4"
                         class="w-full px-6 py-4 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg"></textarea>
              </div>
            </div>

            <div class="pt-6">
              <button type="submit" 
                      class="w-full px-8 py-4 text-xl font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 transition-colors duration-300 shadow-lg hover:shadow-xl">
                تأكيد الطلب
              </button>
            </div>
          </form>
        </div>
      </div>
    
  </ClientLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import ClientLayout from '@/Layouts/ClientLayout.vue';

defineProps({
  products: Array
});

const selectedProducts = ref([]);
const showOrderForm = ref(false);
const orderForm = ref({
  first_name: '',
  last_name: '',
  phone: '',
  address: '',
});

const openOrderForm = () => {
  if (selectedProducts.value.length > 0) {
    showOrderForm.value = true;
  }
};

const submitOrder = () => {
  router.post('/orders/direct', {
    ...orderForm.value,
    products: selectedProducts.value
  }, {
    onSuccess: () => {
      showOrderForm.value = false;
      selectedProducts.value = [];
      // Réinitialiser le formulaire
      orderForm.value = {
        first_name: '',
        last_name: '',
        phone: '',
        address: '',
      };
    },
    onError: (errors) => {
      console.error('Order submission failed:', errors);
    }
  });
};
</script>