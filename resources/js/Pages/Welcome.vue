<template>
  <ClientLayout>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50/20 via-white to-indigo-50/10">
      <!-- Navigation -->
      <nav class="bg-white/95 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 py-3">
          <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
              <div class="relative group cursor-pointer">
                <img src="/images/store_image.jpg" alt="متجر حميد" class="h-10 w-10 rounded-xl object-cover shadow-sm group-hover:scale-105 transition-transform">
                <div class="absolute inset-0 rounded-xl ring-2 ring-indigo-200/50"></div>
              </div>
              <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-indigo-500 bg-clip-text text-transparent">متجر حميد</h1>
            </div>
            <div class="flex items-center gap-4">
              <span class="text-sm text-gray-500">{{ selectedProducts.length }} منتجات مختارة</span>
              <button 
                @click="openOrderForm"
                :disabled="selectedProducts.length === 0"
                class="group flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 disabled:opacity-50 transition-all"
              >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>سلة التسوق</span>
                <span class="px-2 py-0.5 bg-indigo-500 rounded-lg text-xs">{{ selectedProducts.length }}</span>
              </button>
            </div>
          </div>
        </div>
      </nav>

      <!-- Hero Section -->
      <div class="bg-gradient-to-b from-white to-indigo-50/30 border-b border-indigo-100/50">
        <div class="container mx-auto px-4 py-12">
          <div class="max-w-2xl mx-auto text-center space-y-4">
            <h2 class="text-3xl font-bold text-gray-900">اكتشف منتجاتنا المميزة</h2>
            <p class="text-gray-600">اختر من بين مجموعة واسعة من المنتجات عالية الجودة</p>
            <div class="relative mt-8">
              <input 
                v-model="searchQuery"
                type="search"
                placeholder="ابحث عن المنتجات..."
                class="w-full px-6 py-3 rounded-xl bg-white border-2 border-indigo-100 focus:border-indigo-300 focus:ring-4 focus:ring-indigo-100/50 text-base shadow-sm"
              >
              <button class="absolute left-4 top-1/2 -translate-y-1/2 p-2 text-indigo-400 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Categories -->
      <div class="container mx-auto px-4 py-8">
        <div class="flex overflow-x-auto gap-3 pb-4 scrollbar-hide">
          <button 
            v-for="category in categories" 
            :key="category.id"
            @click="selectCategory(category.id)"
            :class="[
              'flex-none px-5 py-2.5 text-sm font-medium rounded-xl transition-all',
              selectedCategory === category.id 
                ? 'bg-indigo-600 text-white shadow-sm' 
                : 'bg-white text-gray-600 border-2 border-indigo-100 hover:bg-indigo-50'
            ]"
          >
            {{ category.name }}
          </button>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mt-8">
          <div v-for="product in filteredProducts" :key="product.id" 
               class="group bg-white rounded-xl border-2 border-indigo-100/50 hover:border-indigo-200 hover:shadow-lg transition-all duration-300">
            <div class="relative aspect-square overflow-hidden rounded-t-xl">
              <img :src="'/storage/' + product.image" :alt="product.name" 
                   class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div class="absolute top-3 left-3">
                <input 
                  type="checkbox" 
                  :value="product.id"
                  v-model="selectedProducts"
                  :disabled="product.stock <= 0"
                  class="w-5 h-5 rounded-lg border-2 border-indigo-200 text-indigo-600 focus:ring-2 focus:ring-indigo-400/50 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                >
              </div>
              <div class="absolute top-3 right-3">
                <span class="px-3 py-1 rounded-lg text-xs font-medium bg-white/95 shadow-sm backdrop-blur-sm"
                      :class="product.stock > 0 ? 'text-emerald-600' : 'text-rose-600'">
                  {{ product.stock > 0 ? 'متوفر' : 'نفذ' }}
                </span>
              </div>
            </div>
            <div class="p-4">
              <h3 class="text-base font-medium text-gray-900 mb-1">{{ product.name }}</h3>
              <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ product.description }}</p>
              <div class="flex items-center justify-between">
                <span class="text-lg font-bold text-indigo-600">{{ product.price }} درهم</span>
                <span class="text-xs bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-lg font-medium">{{ product.stock }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="filteredProducts.length === 0" class="text-center py-12">
          <div class="text-gray-500">لا توجد منتجات متطابقة مع بحثك</div>
        </div>
      </div>
    </div>

    <!-- Order Form Modal -->
    <TransitionRoot appear :show="showOrderForm" as="template">
      <Dialog as="div" @close="showOrderForm = false" class="relative z-50">
        <TransitionChild
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black/30 backdrop-blur-sm" />
        </TransitionChild>

        <div class="fixed inset-0 overflow-y-auto">
          <div class="flex min-h-full items-center justify-center p-4">
            <TransitionChild
              enter="duration-300 ease-out"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
            >
              <DialogPanel class="w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6">
                  <h3 class="text-xl font-bold text-gray-900 mb-4">معلومات الطلب</h3>
                  <form @submit.prevent="submitOrder" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">الاسم الأول</label>
                        <input
                          v-model="orderForm.first_name"
                          type="text"
                          required
                          class="w-full px-4 py-2 rounded-lg border-2 border-indigo-100 focus:border-indigo-300 focus:ring focus:ring-indigo-100/50"
                        >
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">اسم العائلة</label>
                        <input
                          v-model="orderForm.last_name"
                          type="text"
                          required
                          class="w-full px-4 py-2 rounded-lg border-2 border-indigo-100 focus:border-indigo-300 focus:ring focus:ring-indigo-100/50"
                        >
                      </div>
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف</label>
                      <input
                        v-model="orderForm.phone"
                        type="tel"
                        required
                        pattern="[0-9]{10}"
                        class="w-full px-4 py-2 rounded-lg border-2 border-indigo-100 focus:border-indigo-300 focus:ring focus:ring-indigo-100/50"
                      >
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">العنوان</label>
                      <textarea
                        v-model="orderForm.address"
                        required
                        rows="3"
                        class="w-full px-4 py-2 rounded-lg border-2 border-indigo-100 focus:border-indigo-300 focus:ring focus:ring-indigo-100/50"
                      ></textarea>
                    </div>
                    <div class="pt-4">
                      <button
                        type="submit"
                        class="w-full bg-indigo-600 text-white py-3 rounded-xl font-medium hover:bg-indigo-700 transition-colors"
                      >
                        تأكيد الطلب
                      </button>
                    </div>
                  </form>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </ClientLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { Dialog, DialogPanel, TransitionRoot, TransitionChild } from '@headlessui/vue';
import ClientLayout from '@/Layouts/ClientLayout.vue';

const props = defineProps({
  products: Array,
});

const searchQuery = ref('');
const selectedCategory = ref(null);
const selectedProducts = ref([]);
const showOrderForm = ref(false);
const orderForm = ref({
  first_name: '',
  last_name: '',
  phone: '',
  address: '',
});

const categories = [
  { id: null, name: 'جميع المنتجات' },
  { id: 'new', name: 'منتجات جديدة' },
  { id: 'popular', name: 'الأكثر مبيعاً' },
  { id: 'special', name: 'عروض خاصة' },
];

const filteredProducts = computed(() => {
  let filtered = props.products;
  
  if (searchQuery.value) {
    filtered = filtered.filter(product => 
      product.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      product.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  }

  if (selectedCategory.value) {
    // Add category filtering logic here
  }

  return filtered;
});

const selectCategory = (categoryId) => {
  selectedCategory.value = categoryId;
};

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
      orderForm.value = {
        first_name: '',
        last_name: '',
        phone: '',
        address: '',
      };
    },
  });
};
</script>