<template>
    <ClientLayout>
        <div class="rtl" dir="rtl">
            <!-- Hero Section -->
            <div class="relative h-[600px] overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-primary opacity-60"></div>
                <img src="/images/store_image.jpg" alt="متجر حميد" class="w-full h-full object-cover" />
                <div class="absolute bottom-0 right-0 p-12 text-white max-w-2xl">
                    <h1 class="text-5xl font-bold mb-6 leading-tight">مرحباً بكم في متجر حميد</h1>
                    <p class="text-2xl mb-8 leading-relaxed">اكتشف تشكيلتنا الواسعة من المنتجات عالية الجودة</p>
                    <button class="bg-accent hover:bg-accent-dark text-white font-bold py-4 px-8 rounded-full transition duration-300 transform hover:scale-105">
                        تسوق الآن
                    </button>
                </div>
            </div>
            <!-- Featured Products Section -->
            <div class="container mx-auto py-24 px-6">
                <h2 class="text-4xl font-bold mb-16 text-right text-primary">منتجاتنا المميزة</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                    <!-- Product Card 1 -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300">
                        <div class="relative">
                            <img src="/images/product3.png" alt="منتج 1" class="w-full h-72 object-cover" />
                            <div class="absolute top-4 right-4 bg-accent text-white px-4 py-2 rounded-full">جديد</div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-semibold mb-3">منتج مميز 1</h3>
                            <p class="text-gray-600 mb-6">وصف مختصر للمنتج الأول مع مميزاته</p>
                            <div class="flex justify-between items-center">
                                <span class="text-accent text-2xl font-bold">299 درهم</span>
                                <button class="bg-primary hover:bg-primary-dark text-white py-3 px-6 rounded-full transition duration-300">
                                    أضف للسلة
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Card 3 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105">
                        <img src="/images/product3.png" alt="منتج 3" class="w-full h-64 object-cover" />
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">منتج مميز 3</h3>
                            <p class="text-gray-600 mb-4">وصف مختصر للمنتج الثالث مع مميزاته</p>
                            <div class="flex justify-between items-center">
                                <span class="text-primary font-bold">499 درهم</span>
                                <button
                                    class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded transition duration-300">
                                    أضف للسلة
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="bg-gray-100 py-16">
                <div class="container mx-auto px-4">
                    <div class="max-w-3xl mx-auto text-center">
                        <h2 class="text-3xl font-bold mb-8">لماذا متجر حميد؟</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="p-6">
                                <div class="text-4xl mb-4 text-primary">🚚</div>
                                <h3 class="text-xl font-semibold mb-2">توصيل سريع</h3>
                                <p class="text-gray-600">توصيل لجميع أنحاء المدينة</p>
                            </div>
                            <div class="p-6">
                                <div class="text-4xl mb-4 text-primary">⭐</div>
                                <h3 class="text-xl font-semibold mb-2">جودة عالية</h3>
                                <p class="text-gray-600">منتجات مختارة بعناية</p>
                            </div>
                            <div class="p-6">
                                <div class="text-4xl mb-4 text-primary">💯</div>
                                <h3 class="text-xl font-semibold mb-2">ضمان الجودة</h3>
                                <p class="text-gray-600">استرجاع خلال 30 يوم</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ClientLayout>
</template>

<script setup>
import ClientLayout from '@/layouts/ClientLayout.vue';
</script>

<style scoped>
.rtl {
    direction: rtl;
    text-align: right;
}

/* Define primary colors */
:root {
    --color-primary: #3b82f6;
    --color-primary-dark: #2563eb;
}

.bg-primary {
    background-color: var(--color-primary);
}

.bg-primary-dark {
    background-color: var(--color-primary-dark);
}

.text-primary {
    color: var(--color-primary);
}
</style>