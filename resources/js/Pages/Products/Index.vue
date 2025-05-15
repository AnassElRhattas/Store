<template>
  <ClientLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Page Title -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">المنتجات</h1>
      </div>

      <!-- Guest Registration Modal -->
      <div v-if="showGuestForm" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-8 max-w-md w-full shadow-2xl transform transition-all">
          <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">معلومات المستخدم</h2>
          <form @submit.prevent="registerGuest" class="space-y-5">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">الاسم</label>
              <input type="text" v-model="guestForm.name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">اللقب</label>
              <input type="text" v-model="guestForm.surname" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">البريد الإلكتروني</label>
              <input type="email" v-model="guestForm.email" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">رقم الهاتف</label>
              <input type="tel" v-model="guestForm.phone" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">العنوان</label>
              <textarea v-model="guestForm.address" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200" rows="3"></textarea>
            </div>
            <div class="flex justify-end space-x-4 rtl:space-x-reverse">
              <button type="button" @click="showGuestForm = false" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-200">إلغاء</button>
              <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark transform hover:scale-105 transition duration-200">تأكيد</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Products Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <div v-for="product in products" :key="product.id" class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
          <!-- Product Image -->
          <div class="relative aspect-w-3 aspect-h-2 group">
            <img :src="'/storage/' + product.image" :alt="product.name" class="w-full h-56 object-cover transform group-hover:scale-110 transition duration-500">
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
          </div>

          <!-- Product Info -->
          <div class="p-6 space-y-4">
            <h2 class="text-2xl font-bold text-gray-900 line-clamp-1 hover:line-clamp-none">{{ product.name }}</h2>
            <p class="text-gray-600 text-sm line-clamp-2 hover:line-clamp-none">{{ product.description }}</p>
            <div class="flex justify-between items-center pt-4">
              <span class="text-2xl font-bold text-primary">{{ product.price }} درهم</span>
              <button 
                @click="addToCart(product)"
                class="px-6 py-2.5 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-dark transform hover:scale-105 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                :disabled="product.stock === 0"
              >
                {{ product.stock > 0 ? 'أضف إلى السلة' : 'نفذت الكمية' }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- No Products Message -->
      <div v-if="!products.length" class="text-center py-16">
        <p class="text-gray-600 text-xl font-medium">لا توجد منتجات متاحة حالياً</p>
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