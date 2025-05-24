<template>
    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                إضافة منتج جديد
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="handleSubmit" class="space-y-8">
                            <!-- Product Name -->
                            <div class="group relative transition-all duration-300 focus-within:transform focus-within:-translate-y-1">
                                <label for="name" class="block text-lg font-semibold text-gray-700 mb-2">اسم المنتج</label>
                                <input type="text" id="name" v-model="form.name"
                                    class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300"
                                    placeholder="أدخل اسم المنتج" />
                                <div v-if="errors.name" class="mt-2 text-red-600 text-sm">{{ errors.name }}</div>
                            </div>

                            <!-- Product Description -->
                            <div class="group relative transition-all duration-300 focus-within:transform focus-within:-translate-y-1">
                                <label for="description" class="block text-lg font-semibold text-gray-700 mb-2">وصف المنتج</label>
                                <textarea id="description" v-model="form.description" rows="4"
                                    class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300"
                                    placeholder="اكتب وصفاً تفصيلياً للمنتج"></textarea>
                                <div v-if="errors.description" class="mt-2 text-red-600 text-sm">{{ errors.description }}</div>
                            </div>

                            <!-- Price and Stock Group -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Price Input -->
                                <div class="group relative transition-all duration-300 focus-within:transform focus-within:-translate-y-1">
                                    <label for="price" class="block text-lg font-semibold text-gray-700 mb-2">السعر</label>
                                    <div class="relative">
                                        <input type="number" step="0.01" id="price" v-model="form.price"
                                            class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300"
                                            placeholder="0.00" />
                                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">درهم</span>
                                    </div>
                                    <div v-if="errors.price" class="mt-2 text-red-600 text-sm">{{ errors.price }}</div>
                                </div>

                                <!-- Stock Input -->
                                <div class="group relative transition-all duration-300 focus-within:transform focus-within:-translate-y-1">
                                    <label for="stock" class="block text-lg font-semibold text-gray-700 mb-2">الكمية المتوفرة</label>
                                    <input type="number" id="stock" v-model="form.stock"
                                        class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-300"
                                        placeholder="0" min="0" />
                                    <div v-if="errors.stock" class="mt-2 text-red-600 text-sm">{{ errors.stock }}</div>
                                </div>
                            </div>

                            <!-- Status Toggle -->
                            <div class="flex items-center space-x-4 space-x-reverse">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" v-model="form.is_active" class="sr-only peer">
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:right-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600"></div>
                                    <span class="mr-3 text-lg font-semibold text-gray-700">متوفر للبيع</span>
                                </label>
                            </div>

                            <!-- Image Upload -->
                            <div class="group relative transition-all duration-300 focus-within:transform focus-within:-translate-y-1">
                                <label for="image" class="block text-lg font-semibold text-gray-700 mb-2">صورة المنتج</label>
                                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl hover:border-indigo-500 transition-all duration-300">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>اختر صورة</span>
                                                <input id="image" type="file" @change="handleImageChange" class="sr-only" accept="image/*">
                                            </label>
                                            <p class="pr-2">أو اسحب وأفلت</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG حتى 10MB</p>
                                    </div>
                                </div>
                                <div v-if="errors.image" class="mt-2 text-red-600 text-sm">{{ errors.image }}</div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-6">
                                <button type="submit" :disabled="processing"
                                    class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span v-if="processing" class="ml-2">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                    {{ processing ? 'جاري الحفظ...' : 'حفظ المنتج' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const form = useForm({
    name: '',
    description: '',
    price: '',
    stock: 0,
    image: null,
    is_active: true
})

const processing = ref(false)
const errors = ref({})

const handleImageChange = (e) => {
    form.image = e.target.files[0]
}

const handleSubmit = () => {
    processing.value = true
    form.post('/admin/products/store', {
        onSuccess: () => {
            processing.value = false
            form.reset()
        },
        onError: (errors) => {
            processing.value = false
        }
    })
}
</script>