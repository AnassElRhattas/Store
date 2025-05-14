<template>
    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                إضافة منتج
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">

                        <form @submit.prevent="handleSubmit" class="space-y-6 min-w-full divide-y divide-gray-200">
                            <div class="py-4">
                                <label for="name" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">اسم المنتج</label>
                                <input type="text" id="name" v-model="form.name"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <div v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</div>
                            </div>

                            <div class="py-4">
                                <label for="description" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">وصف المنتج</label>
                                <textarea id="description" v-model="form.description" rows="4"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                <div v-if="errors.description" class="text-red-500 text-sm mt-1">{{ errors.description }}</div>
                            </div>

                            <div class="py-4">
                                <label for="price" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">السعر</label>
                                <input type="number" step="0.01" id="price" v-model="form.price"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <div v-if="errors.price" class="text-red-500 text-sm mt-1">{{ errors.price }}</div>
                            </div>

                            <div class="py-4">
                                <label for="image" class="block text-sm font-medium text-gray-500 uppercase tracking-wider">صورة المنتج</label>
                                <input type="file" id="image" @change="handleImageChange" class="mt-2 block w-full"
                                    accept="image/*" />
                                <div v-if="errors.image" class="text-red-500 text-sm mt-1">{{ errors.image }}</div>
                            </div>

                            <div class="py-4 flex items-center">
                                <input type="checkbox" id="is_active" v-model="form.is_active"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                                <label for="is_active" class="mr-2 block text-sm font-medium text-gray-500 uppercase tracking-wider">متوفر للبيع</label>
                            </div>

                            <div class="py-4 flex justify-end">
                                <button type="submit" :disabled="processing"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ processing ? 'جاري الحفظ...' : 'حفظ المنتج' }}
                                </button>
                            </div>
                        </form>
                    </div>
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