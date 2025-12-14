<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Manajemen Pesanan</h1>
        <p class="text-gray-600 text-sm">Kelola pesanan terbaru, status, dan detail pelanggan.</p>
      </div>
    </header>

    <!-- FILTERS -->
    <BaseCard class="p-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
          <OrdersFilter @update:filter="updateFilter" />
        </div>
        <div class="flex justify-end w-full md:w-auto">
          <OrdersSearch v-model="search" class="w-full md:w-64" />
        </div>
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard>
      <div class="flex justify-between items-center mb-5">
        <h2 class="heading-2">Daftar Pesanan</h2>
      </div>

      <BaseTable v-if="filteredRows.length > 0" :columns="columns" :rows="filteredRows">
        <!-- Status Badge -->
        <template #status="{ row }">
          <BaseStatusBadge :status="row.status" />
        </template>

        <!-- Actions -->
        <template #action="{ row }">
          <OrdersRowActions
            :item="row"
            @detail="openModal('detail', row)"
            @edit="openModal('edit', row)"
          />
        </template>
      </BaseTable>

      <!-- Empty State -->
      <BaseEmptyState
        v-else
        title="Tidak ada Pesanan Ditemukan"
        description="Silahkan ubah filter pencarian Anda."
        :icon="Receipt"
      />
    </BaseCard>

    <!-- MODAL ORDERS -->
    <OrdersModal
      v-model="showModal"
      :mode="modalMode"
      :item-data="selectedItem"
      :status-options="statusOptions.filter(s => s !== 'Status')"
      :driver-options="driverOptions.map(d => d.nama_driver)"
      @save="handleSaveOrder"
    />
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseStatusBadge from "@/components/base/BaseStatusBadge.vue";
import OrdersSearch from "@/components/admin/orders/OrdersSearch.vue";
import OrdersFilter from "@/components/admin/orders/OrdersFilter.vue";
import OrdersRowActions from "@/components/admin/orders/OrdersRowActions.vue";
import OrdersModal from "@/components/admin/orders/OrdersModal.vue";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";
import { Receipt } from "lucide-vue-next";
import { OrdersAPI } from "@/api/orders.js";

const columns = [
  { label: "ID Pesanan", field: "id" },
  { label: "Pelanggan", field: "customer" },
  { label: "Tanggal", field: "date" },
  { label: "Status", field: "status" },
  { label: "Driver", field: "driver" },
  { label: "Aksi", field: "action" }
];

const statusOptions = ["Diproses","Dikirim","Selesai","Dibatalkan"];
const driverOptions = ref([]);

const search = ref("");
const filters = ref({ status: "", date: "" });
const items = ref([]);

// Modal State
const showModal = ref(false);
const modalMode = ref("detail");
const selectedItem = ref(null);

// ==============================
// Fetch data pesanan & driver
// ==============================
const fetchOrders = async () => {
  try {
    const data = await OrdersAPI.getOrders();
    items.value = data.map(order => ({
      id: order.id_pesanan,
      customer: order.user?.nama_user || "N/A",
      customerPhone: order.user?.no_telp || "",
      customerAddress: order.alamat?.alamat || "",
      status: order.status,
      driver: order.driver?.nama_driver || "Belum ditetapkan",
      driverPhone: order.driver?.no_telp || "",
      driverVehicle: order.driver ? `${order.driver.tipe_kendaraan} / ${order.driver.plat_kendaraan}` : "",
      date: new Date(order.tanggal_pesanan).toLocaleDateString("id-ID"),
      items: order.detail.map(d => ({
        name: d.menu?.menu || "N/A",
        qty: d.jumlah,
        price: d.menu?.harga || 0,
        image: d.menu?.gambar || "https://via.placeholder.com/150"
      }))
    }));
  } catch (err) {
    console.error("Gagal fetch pesanan:", err);
  }
};

const fetchDrivers = async () => {
  try {
    driverOptions.value = await OrdersAPI.getDrivers();
  } catch (err) {
    console.error("Gagal fetch driver:", err);
  }
};

// ==============================
// Modal & Filter Logic
// ==============================
const openModal = (mode, item) => {
  modalMode.value = mode;
  selectedItem.value = item;
  showModal.value = true;
};

const updateFilter = (payload) => {
  filters.value = { ...filters.value, ...payload };
};

const filteredRows = computed(() => {
  return items.value.filter((item) => {
    const q = search.value.toLowerCase();
    const matchSearch = item.id.toLowerCase().includes(q) || item.customer.toLowerCase().includes(q);
    const matchStatus = !filters.value.status || filters.value.status === "Status" || item.status === filters.value.status;
    const matchDate = !filters.value.date || item.date === filters.value.date;
    return matchSearch && matchStatus && matchDate;
  });
});

// ==============================
// Handle save order
// ==============================
const handleSaveOrder = async ({ id, status, driver }) => {
  try {
    await OrdersAPI.updateStatus(id, status);

    if (status === "Dikirim" && driver && driver !== "Belum ditetapkan") {
      const driverData = driverOptions.value.find(d => d.nama_driver === driver);
      if (driverData) {
        await OrdersAPI.assignDriver(id, driverData.id_driver);
      }
    }

    await fetchOrders();
  } catch (err) {
    console.error("Gagal update pesanan:", err);
  }
};

// ==============================
// Mounted
// ==============================
onMounted(() => {
  fetchOrders();
  fetchDrivers();
});
</script>
