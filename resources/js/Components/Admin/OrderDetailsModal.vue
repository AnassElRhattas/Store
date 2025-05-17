<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel class="w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 text-right align-middle shadow-xl transition-all">
              <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 mb-4">
                تفاصيل الطلب #{{ order.id }}
              </DialogTitle>

              <div class="mt-4 space-y-4">
                <!-- Customer Information -->
                <div class="border-b pb-4">
                  <h4 class="font-semibold mb-2">معلومات العميل</h4>
                  <p>{{ order.user.name }} {{ order.user.surname }}</p>
                </div>

                <!-- Shipping Information -->
                <div class="border-b pb-4">
                  <h4 class="font-semibold mb-2">معلومات التوصيل</h4>
                  <p class="text-gray-600">{{ order.shipping_address }}</p>
                </div>

                <!-- Order Items -->
                <div class="space-y-2">
                  <h4 class="font-semibold mb-2">العناصر المطلوبة</h4>
                  <div v-for="item in order.items" :key="item.id" class="flex justify-between items-center py-2">
                    <div>
                      <span class="font-medium">{{ item.product.name }}</span>
                      <span class="text-gray-500 text-sm"> x{{ item.quantity }}</span>
                    </div>
                    <span class="font-medium">{{ item.product.price * item.quantity }} درهم</span>
                  </div>
                </div>

                <!-- Order Total -->
                <div class="border-t pt-4 flex justify-between items-center">
                  <span class="font-semibold">المجموع</span>
                  <span class="text-lg font-bold">{{ order.total_amount }} درهم</span>
                </div>

                <!-- Order Status -->
                <div class="border-t pt-4">
                  <h4 class="font-semibold mb-2">حالة الطلب</h4>
                  <div class="flex items-center justify-between">
                    <span :class="{
                      'text-yellow-600': order.status === 'pending',
                      'text-green-600': order.status === 'approved',
                      'text-red-600': order.status === 'rejected'
                    }">
                      {{ getStatusText(order.status) }}
                    </span>
                    <div v-if="order.status === 'pending'" class="space-x-2 rtl:space-x-reverse">
                      <button
                        @click="updateStatus('approved')"
                        class="px-3 py-1 text-sm bg-green-600 text-white rounded-full hover:bg-green-700"
                      >
                        قبول
                      </button>
                      <button
                        @click="updateStatus('rejected')"
                        class="px-3 py-1 text-sm bg-red-600 text-white rounded-full hover:bg-red-700"
                      >
                        رفض
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-6 flex justify-between items-center">
                <button
                  @click="generatePDF"
                  class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                >
                  تحميل PDF
                </button>
                <button
                  @click="closeModal"
                  class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900"
                >
                  إغلاق
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true
  },
  order: {
    type: Object,
    required: false,
    default: () => ({})
  }
})

const emit = defineEmits(['close', 'statusUpdated'])

const form = useForm({
  status: ''
})

const closeModal = () => {
  form.reset()
  emit('close')
}

const getStatusText = (status) => {
  switch (status) {
    case 'pending':
      return 'قيد الانتظار'
    case 'approved':
      return 'تم القبول'
    case 'rejected':
      return 'تم الرفض'
    default:
      return status
  }
}

const updateStatus = (status) => {
  form.status = status
  form.patch(`/admin/orders/${props.order.id}`, {
    onSuccess: () => {
      emit('statusUpdated')
    }
  })
}

const generatePDF = () => {
  form.post(`/admin/orders/${props.order.id}/pdf`, {
    onSuccess: () => {
      emit('pdfGenerated')
    }
  })
}
</script>