<template>
    <ClientLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-2xl font-bold mb-4">طلباتي</h2>

                        <div v-if="orders.data.length > 0" class="space-y-6">
                            <div v-for="order in orders.data" :key="order.id" 
                                class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold">طلب #{{ order.id }}</h3>
                                        <p class="text-gray-600">{{ order.shipping_address }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold">{{ order.total_amount }} درهم</p>
                                        <span class="inline-block px-2 py-1 text-sm rounded"
                                            :class="{
                                                'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                                'bg-green-100 text-green-800': order.status === 'completed',
                                                'bg-red-100 text-red-800': order.status === 'cancelled'
                                            }">
                                            {{ 
                                                order.status === 'pending' ? 'قيد الانتظار' :
                                                order.status === 'completed' ? 'مكتمل' :
                                                order.status === 'cancelled' ? 'ملغي' : order.status 
                                            }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-sm text-gray-500">
                                        {{ new Date(order.created_at).toLocaleDateString('ar-MA') }}
                                    </p>
                                    <button @click="router.visit(route('orders.show', order.id))"
                                        class="text-blue-600 hover:text-blue-800">
                                        عرض التفاصيل ←
                                    </button>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div v-if="orders.links.length > 3" class="mt-6">
                                <div class="flex justify-center gap-2">
                                    <template v-for="(link, index) in orders.links" :key="index">
                                        <button v-if="link.url" 
                                            @click="router.visit(link.url)"
                                            :class="{
                                                'bg-blue-500 text-white': link.active,
                                                'bg-white text-gray-700 hover:bg-gray-50': !link.active
                                            }"
                                            class="px-4 py-2 border rounded-md transition-colors"
                                            v-html="link.label">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-8 text-gray-600">
                            <p>لا توجد طلبات حتى الآن</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ClientLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import ClientLayout from '@/Layouts/ClientLayout.vue'

defineProps({
    orders: {
        type: Object,
        required: true
    }
})
</script>