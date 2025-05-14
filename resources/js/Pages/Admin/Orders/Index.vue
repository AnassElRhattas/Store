<template>
  <AdminLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        الطلبات
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <h2 class="text-lg font-medium text-gray-900 mb-6">المبيعات</h2>
            <div class="border-t border-gray-200">
              <ul class="divide-y divide-gray-200">
                <li v-for="order in orders" :key="order.id" class="p-4">
                  <div class="flex items-center justify-between">
                    <div class="flex-1">
                      <h3 class="text-sm font-medium">طلب #{{ order.id }}</h3>
                      <p class="text-sm text-gray-500">{{ order.user.name }}</p>
                      <p class="text-sm text-gray-500">{{ order.created_at }}</p>
                      <div class="mt-2">
                        <div v-for="item in order.items" :key="item.id" class="flex justify-between text-sm">
                          <span>{{ item.product.name }}</span>
                          <span>x{{ item.quantity }}</span>
                        </div>
                      </div>
                      <p class="mt-2 text-sm font-medium">المجموع: {{ order.total }} ريال</p>
                    </div>
                    <div class="ml-4">
                      <div v-if="order.status === 'pending'" class="space-x-2 rtl:space-x-reverse">
                        <button
                          @click="updateOrderStatus(order.id, 'approved')"
                          class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                          قبول
                        </button>
                        <button
                          @click="updateOrderStatus(order.id, 'rejected')"
                          class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                          رفض
                        </button>
                      </div>
                      <span
                        v-else-if="order.status === 'approved'"
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                      >
                        تم القبول
                      </span>
                      <span
                        v-else-if="order.status === 'rejected'"
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"
                      >
                        تم الرفض
                      </span>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  orders: {
    type: Array,
    required: true
  }
});

const form = useForm({});

const updateOrderStatus = (orderId, status) => {
  form.patch(`/admin/orders/${orderId}`, {
    status: status
  });
};
</script>