<template>
  <ClientLayout>
    <!-- Remove py-12 to maximize vertical space -->
    <div>
      <!-- Remove max-w-7xl and padding constraints to allow full width -->
      <div class="w-full">
        <div class="overflow-hidden bg-white shadow-sm">
          <div class="p-6 text-gray-900">
            <!-- Hero Section - Make it full width -->
            <div class="relative h-[400px] overflow-hidden mb-8">
              <img src="/images/store_image.jpg" alt="متجر حميد" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-center text-white">
                  <h1 class="text-4xl font-bold mb-4">مرحباً بكم في متجر حميد</h1>
                  <p class="text-xl">أفضل المنتجات بأسعار مناسبة</p>
                </div>
              </div>
            </div>

            <!-- Store Information - Full width -->
            <div class="mb-8 w-full">
              <h2 class="text-xl font-semibold mb-4 text-gray-800">من نحن</h2>
              <p class="text-gray-600">
                نحن متجر متخصص في توفير أفضل المنتجات بجودة عالية وأسعار منافسة. نسعى دائماً لتقديم أفضل خدمة لعملائنا الكرام.
              </p>
            </div>

            <!-- Store Features - Full width grid -->
            <div class="mb-8 w-full">
              <h2 class="text-xl font-semibold mb-4 text-gray-800">مميزات متجرنا</h2>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                <div class="p-4 bg-gray-50 rounded-lg">
                  <h3 class="font-semibold mb-2">توصيل سريع</h3>
                  <p class="text-gray-600">خدمة توصيل سريعة وموثوقة لجميع مناطق المدينة</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                  <h3 class="font-semibold mb-2">جودة عالية</h3>
                  <p class="text-gray-600">نقدم منتجات ذات جودة عالية وضمان حقيقي</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                  <h3 class="font-semibold mb-2">دعم متواصل</h3>
                  <p class="text-gray-600">فريق دعم متاح على مدار الساعة لخدمتكم</p>
                </div>
              </div>
            </div>

            <!-- Latest Products - Full width grid -->
            <div class="mb-8 w-full">
              <h2 class="text-xl font-semibold mb-4 text-gray-800">أحدث المنتجات</h2>
              <div v-if="products.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                <div v-for="product in products" :key="product.id" class="bg-gray-50 rounded-lg p-4">
                  <img :src="'/storage/' + product.image" :alt="product.name" class="w-full h-48 object-cover rounded-lg mb-4">
                  <h3 class="font-semibold text-gray-800 mb-2">{{ product.name }}</h3>
                  <p class="text-gray-600 mb-4 line-clamp-2">{{ product.description }}</p>
                  <div class="flex justify-between items-center">
                    <span class="text-gray-800 font-semibold">{{ product.price }} درهم</span>
                    <button @click="addToCart(product)" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                      أضف للسلة
                    </button>
                  </div>
                </div>
              </div>
              <div v-else class="text-center text-gray-500">
                لا توجد منتجات متاحة حالياً
              </div>
            </div>

            <!-- Contact Information - Full width grid -->
            <div class="mb-8 w-full">
              <h2 class="text-xl font-semibold mb-4 text-gray-800">تواصل معنا</h2>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                <div class="p-4 bg-gray-50 rounded-lg text-center">
                  <h3 class="font-semibold mb-2">العنوان</h3>
                  <p class="text-gray-600">شارع الرئيسي، المدينة</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-center">
                  <h3 class="font-semibold mb-2">الهاتف</h3>
                  <p class="text-gray-600">+212 123-456-789</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-center">
                  <h3 class="font-semibold mb-2">البريد الإلكتروني</h3>
                  <p class="text-gray-600">info@store-hamid.com</p>
                </div>
              </div>
            </div>

            <!-- Newsletter - Full width -->
            <div class="bg-gray-50 rounded-lg p-6 text-center w-full">
              <h2 class="text-xl font-semibold mb-4 text-gray-800">اشترك في نشرتنا البريدية</h2>
              <p class="text-gray-600 mb-4">احصل على آخر العروض والتحديثات مباشرة إلى بريدك الإلكتروني</p>
              <form @submit.prevent="subscribeNewsletter" class="flex flex-col md:flex-row gap-4 justify-center">
                <input
                  v-model="email"
                  type="email"
                  placeholder="البريد الإلكتروني"
                  class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-gray-500"
                  required
                >
                <button
                  type="submit"
                  class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors"
                >
                  اشتراك
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </ClientLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const products = usePage().props.products || [];
const email = ref('');

const subscribeNewsletter = () => {
  // Handle newsletter subscription
  console.log('Subscribing email:', email.value);
  // Add your newsletter subscription logic here
  email.value = '';
};

const addToCart = (product) => {
  if (!usePage().props.auth.user) {
    router.visit(route('login'));
    return;
  }
  
  router.post(route('cart.add', product.id), {
    quantity: 1
  }, {
    preserveScroll: true,
    onSuccess: () => {
      router.visit(route('cart.index'));
    }
  });
};
</script>