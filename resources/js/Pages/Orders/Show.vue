<template>
    <ClientLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-2xl font-bold mb-4">تفاصيل الطلب</h2>

                        <div v-if="order" class="space-y-6">
                            <div class="border-b pb-4">
                                <h3 class="text-lg font-semibold mb-2">معلومات التوصيل</h3>
                                <p class="text-gray-600">{{ order.shipping_address }}</p>
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold">العناصر المطلوبة</h3>
                                <div v-for="item in order.items" :key="item.id" class="flex items-center justify-between border-b pb-4">
                                    <div class="flex items-center space-x-4">
                                        <img v-if="item.product.image" :src="`/storage/${item.product.image}`"
                                            :alt="item.product.name" class="w-20 h-20 object-cover rounded">
                                        <div>
                                            <h4 class="font-semibold">{{ item.product.name }}</h4>
                                            <p class="text-gray-600">{{ item.product.price }} درهم x {{ item.quantity }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold">{{ item.product.price * item.quantity }} درهم</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center pt-4">
                                    <h3 class="text-lg font-semibold">المجموع</h3>
                                    <p class="text-xl font-bold">{{ orderTotal }} درهم</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button @click="router.visit(route('orders.index'))" 
                                    class="text-blue-600 hover:text-blue-800">
                                    ← العودة إلى الطلبات
                                </button>
                            </div>
                        </div>

                        <div v-else class="text-gray-600">
                            <p>لم يتم العثور على الطلب</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ClientLayout>
</template>

<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'
import ClientLayout from '@/Layouts/ClientLayout.vue'

const props = defineProps({
    order: {
        type: Object,
        required: true
    }
})

const orderTotal = computed(() => {
    if (!props.order || !props.order.items) return 0
    return props.order.items.reduce((total, item) => {
        return total + (item.product.price * item.quantity)
    }, 0)
})
</script>