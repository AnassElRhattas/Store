<template>
  <ClientLayout>
    <div class="min-h-screen bg-gray-100">
      <!-- Search and Filter Bar -->
      <div class="sticky top-0 z-10 bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4">
          <div class="flex items-center justify-between">
            <div class="relative flex-1 max-w-xl">
              <input type="search" placeholder="ابحث عن منتج..." 
                     class="w-full pl-10 pr-4 py-2 rounded-full border-gray-200 focus:border-purple-500 focus:ring-purple-500">
              <span class="absolute right-3 top-2.5 text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Products Grid -->
      <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="product in products" :key="product.id" 
               class="bg-white rounded-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100">
            <div class="relative group">
              <img :src="'/storage/' + product.image" :alt="product.name" 
                   class="w-full h-64 object-cover">
              <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-40 transition-opacity duration-300"></div>
              <div class="absolute top-4 right-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold"
                      :class="product.stock > 0 ? 'bg-green-500 text-white' : 'bg-red-500 text-white'">
                  {{ product.stock > 0 ? 'متوفر' : 'نفذت الكمية' }}
                </span>
              </div>
            </div>

            <div class="p-5">
              <h3 class="text-xl font-bold text-gray-900 mb-2">{{ product.name }}</h3>
              <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ product.description }}</p>
              
              <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                <span class="text-2xl font-bold text-purple-600">{{ product.price }} درهم</span>
                <button @click="addToCart(product)"
                        :disabled="product.stock === 0"
                        class="flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-300"
                        :class="product.stock > 0 ? 'bg-purple-600 text-white hover:bg-purple-700' : 'bg-gray-200 text-gray-400'">
                  <svg class="w-5 h-5 mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                  </svg>
                  {{ product.stock > 0 ? 'أضف إلى السلة' : 'نفذت الكمية' }}
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="!products.length" class="flex flex-col items-center justify-center py-20">
          <img src="/images/empty-cart.svg" alt="No products" class="w-48 h-48 mb-6">
          <h3 class="text-2xl font-bold text-gray-900 mb-2">لا توجد منتجات</h3>
          <p class="text-gray-600">سيتم إضافة منتجات جديدة قريباً</p>
        </div>
      </div>

      <!-- Guest Form Modal -->
      <div v-if="showGuestForm" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">تسجيل كزائر</h2>
            <button @click="showGuestForm = false" class="text-gray-400 hover:text-gray-600">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          
          <form @submit.prevent="registerGuest" class="space-y-6">
            <div v-for="(field, key) in guestFormFields" :key="key">
              <label :for="key" class="block text-sm font-medium text-gray-700 mb-2">{{ field.label }}</label>
              <input v-if="field.type !== 'textarea'"
                     :type="field.type"
                     :id="key"
                     v-model="guestForm[key]"
                     required
                     class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500">
              <textarea v-else
                        :id="key"
                        v-model="guestForm[key]"
                        required
                        rows="3"
                        class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-purple-500 focus:ring-purple-500">
              </textarea>
            </div>
            
            <div class="flex justify-end space-x-4 rtl:space-x-reverse">
              <button type="button" @click="showGuestForm = false" 
                      class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                إلغاء
              </button>
              <button type="submit" 
                      class="px-6 py-3 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                تأكيد
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </ClientLayout>
</template>

<script setup>
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { defineProps, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const props = defineProps({
  products: {
    type: Array,
    required: true
  }
});

const page = usePage();
const showGuestForm = ref(false);
const guestForm = ref({
  name: '',
  surname: '',
  email: '',
  phone: '',
  address: ''
});

const guestFormFields = {
  name: { label: 'الاسم', type: 'text' },
  surname: { label: 'اللقب', type: 'text' },
  email: { label: 'البريد الإلكتروني', type: 'email' },
  phone: { label: 'رقم الهاتف', type: 'tel' },
  address: { label: 'العنوان', type: 'textarea' }
};

const addToCart = (product) => {
  if (!page.props.auth.user) {
    showGuestForm.value = true;
  } else {
    router.post(`/cart/add/${product.id}`, {}, {
      preserveScroll: true
    });
  }
};

const registerGuest = () => {
  router.post('/guest/register', guestForm.value, {
    onSuccess: () => {
      showGuestForm.value = false;
      router.visit('/client/dashboard');
    }
  });
};
</script>