<template>
    <ClientLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-2xl font-bold mb-4">Mon Panier</h2>

                        <div v-if="!cartItems.length" class="text-gray-600">
                            <p>Votre panier est vide.</p>
                        </div>
                        <div v-else class="space-y-4">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" 
                                    v-model="selectAll"
                                    @change="toggleSelectAll"
                                    class="rounded border-gray-300 mr-2">
                                <label class="text-sm text-gray-600">Tout sélectionner</label>
                            </div>

                            <div v-for="item in cartItems" :key="item.id"
                                class="flex items-center justify-between border-b pb-4">
                                <div class="flex items-center space-x-4">
                                    <input type="checkbox" 
                                        v-model="selectedItems[item.id]"
                                        @change="updateSelectedTotal"
                                        class="rounded border-gray-300">
                                    <img v-if="item.product.image" :src="`/storage/${item.product.image}`"
                                        :alt="item.product.name" class="w-20 h-20 object-cover rounded">
                                    <div>
                                        <h3 class="font-semibold">{{ item.product.name }}</h3>
                                        <p class="text-gray-600">{{ item.product.price }} درهم</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <input type="number" v-model="item.quantity" min="1"
                                            class="w-16 rounded-md border-gray-300" @change="updateQuantity(item)">
                                        <button @click="updateQuantity(item)"
                                            class="ml-2 text-sm text-blue-600 hover:text-blue-800">
                                            Mettre à jour
                                        </button>
                                    </div>
                                    <button @click="removeItem(item)" class="text-sm text-red-600 hover:text-red-800">
                                        Supprimer
                                    </button>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between items-center">
                                <div class="text-xl font-bold">Total sélectionné: {{ selectedTotal }} درهم</div>
                                <button @click="proceedToCheckout"
                                    :disabled="!hasSelectedItems"
                                    :class="[hasSelectedItems ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed', 'text-white px-6 py-2 rounded-md']">
                                    Commander
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ClientLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import ClientLayout from '@/Layouts/ClientLayout.vue'

const props = defineProps({
    cartItems: {
        type: Array,
        default: () => []
    },
    total: {
        type: Number,
        default: 0
    }
})

const selectedItems = ref({})
const selectAll = ref(false)

const hasSelectedItems = computed(() => {
    return Object.values(selectedItems.value).some(value => value)
})

const selectedTotal = computed(() => {
    return props.cartItems.reduce((acc, item) => {
        if (selectedItems.value[item.id]) {
            return acc + (item.product.price * item.quantity)
        }
        return acc
    }, 0)
})

const toggleSelectAll = () => {
    props.cartItems.forEach(item => {
        selectedItems.value[item.id] = selectAll.value
    })
    updateSelectedTotal()
}

const updateSelectedTotal = () => {
    selectAll.value = props.cartItems.length > 0 && 
        props.cartItems.every(item => selectedItems.value[item.id])
}

const updateQuantity = (item) => {
    router.patch(route('cart.update', item.product_id), {
        quantity: item.quantity
    })
}

const removeItem = (item) => {
    router.delete(route('cart.remove', item.id))
    delete selectedItems.value[item.id]
    updateSelectedTotal()
}

const proceedToCheckout = () => {
    const selectedItemIds = props.cartItems
        .filter(item => selectedItems.value[item.id])
        .map(item => item.id)

    if (selectedItemIds.length === 0) {
        alert('Veuillez sélectionner des articles pour passer la commande')
        return
    }

    const user = usePage().props.auth.user
    
    if (!user.address) {
        alert('Veuillez mettre à jour votre adresse dans votre profil')
        return
    }

    router.post(route('orders.store'), {
        selectedItems: selectedItemIds,
        shipping_address: user.address,
        payment_method: 'cash' // Adding the required payment_method field
    })
}
</script>