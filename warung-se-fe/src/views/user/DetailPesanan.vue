<template>
  <div v-if="orderData" class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">
      Detail Pesanan #{{ orderId }}
    </h2>

    <!-- CUSTOMER -->
    <div class="bg-gray-50 p-4 rounded-lg">
      <p class="font-semibold">Pelanggan</p>
      <p>{{ orderData.customer?.name ?? "-" }}</p>
      <p>{{ orderData.customer?.phone ?? "-" }}</p>
      <p class="text-sm text-gray-600">
        {{ orderData.customer?.address ?? "-" }}
      </p>
    </div>

    <!-- ITEMS -->
    <div>
      <h3 class="font-semibold mb-2">Item Pesanan</h3>

      <div
        v-if="orderData.items?.length"
        class="space-y-2"
      >
        <div
          v-for="(item, i) in orderData.items"
          :key="i"
          class="flex justify-between border-b pb-1"
        >
          <span>{{ item.name }} ({{ item.qty }}x)</span>
          <span>{{ formatCurrency(item.total) }}</span>
        </div>
      </div>

      <p v-else class="text-gray-500 text-sm">
        Tidak ada item
      </p>
    </div>

    <!-- TOTAL -->
    <div class="border-t pt-4 space-y-1">
      <div class="flex justify-between">
        <span>Subtotal</span>
        <span>{{ formatCurrency(orderData.subtotal) }}</span>
      </div>
      <div class="flex justify-between font-bold text-lg">
        <span>Total</span>
        <span>{{ formatCurrency(orderData.total) }}</span>
      </div>
    </div>

    <UserAppButton class="w-full" @click="$emit('close')">
      Tutup
    </UserAppButton>
  </div>

  <div v-else class="text-center text-gray-500">
    Memuat data pesanan...
  </div>
</template>

<script setup>
import UserAppButton from "@/components/baseUser/UserAppButton.vue";

defineProps({
  orderData: {
    type: Object,
    default: null,
  },
  orderId: {
    type: [String, Number],
    default: null,
  },
});

function formatCurrency(val) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
  }).format(val || 0);
}
</script>
