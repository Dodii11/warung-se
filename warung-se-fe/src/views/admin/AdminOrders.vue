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
      >
        <template #icon>
          <!-- gunakan component icon Vue bukan function -->
          <Receipt class="w-12 h-12 text-gray-300" />
        </template>
      </BaseEmptyState>
    </BaseCard>

    <!-- MODAL ORDERS -->
    <OrdersModal
      v-model="showModal"
      :mode="modalMode"
      :item-data="selectedItem"
      :status-options="statusOptions.filter((s) => s !== 'Status')"
      :driver-options="driverOptions"
      :driver-options-map="driverMap"
      @save="handleSaveOrder"
    />
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";

// ==============================
// Base Components
// ==============================
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseStatusBadge from "@/components/base/BaseStatusBadge.vue";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";

// ==============================
// Orders Components
// ==============================
import OrdersSearch from "@/components/admin/orders/OrdersSearch.vue";
import OrdersFilter from "@/components/admin/orders/OrdersFilter.vue";
import OrdersRowActions from "@/components/admin/orders/OrdersRowActions.vue";
import OrdersModal from "@/components/admin/orders/OrdersModal.vue";

// ==============================
// Icons & API
// ==============================
import { Receipt } from "lucide-vue-next";
import { OrdersAPI } from "@/api/orders.js";

// ==============================
// TABLE CONFIG
// ==============================
const columns = [
  { label: "ID Pesanan", key: "id" },
  { label: "Pelanggan", key: "customer" },
  { label: "Tanggal", key: "date" },
  { label: "Total", key: "total" },
  { label: "Status", key: "status" },
  { label: "Driver", key: "driver" },
];

const statusOptions = ["Tertunda", "Diproses", "Dikirim", "Selesai", "Dibatalkan"];
const driverOptions = ref([]);

const search = ref("");
const filters = ref({ status: "", date: "" });
const items = ref([]);
const driverMap = ref({});

const SHIPPING_COST = 5000;

const calculateTotal = (details = []) => {
  if (!Array.isArray(details)) return 0;

  const subtotal = details.reduce((sum, item) => {
    return sum + (item.jumlah || 0) * (item.menu?.harga || 0);
  }, 0);

  return subtotal + SHIPPING_COST;
};

const formatCurrency = (v) => `Rp ${Number(v).toLocaleString("id-ID")}`;

// ==============================
// MODAL STATE
// ==============================
const showModal = ref(false);
const modalMode = ref("detail");
const selectedItem = ref(null);

// ==============================
// FETCH DATA
// ==============================
const fetchOrders = async () => {
  try {
    const data = await OrdersAPI.getAdminOrders();

    items.value = data.map((order) => {
      const total = calculateTotal(order.detail);
      return {
        id: order.id_pesanan.toString(),
        customer: order.user?.nama_user || "-",
        status: order.status,
        driver: order.driver?.nama_driver || "Belum ditetapkan",
        date: new Date(order.tanggal_pesanan).toLocaleDateString("id-ID"),

        total: formatCurrency(total),

        items: order.detail || [],
        raw: order,
      };
    });
  } catch (err) {
    console.error("Gagal fetch pesanan admin:", err);
    items.value = [];
  }
};

const fetchDrivers = async () => {
  try {
    const data = await OrdersAPI.getDrivers();

    // dropdown BUTUH NAMA
    driverOptions.value = data.map((d) => d.nama_driver);

    // map NAMA -> ID
    driverMap.value = data.reduce((acc, d) => {
      acc[d.nama_driver] = d.id_driver;
      return acc;
    }, {});
  } catch (err) {
    console.error("Gagal fetch driver:", err);
  }
};

// ==============================
// FILTER & MODAL
// ==============================
const openModal = (mode, item) => {
  modalMode.value = mode;
  selectedItem.value = item.raw;
  showModal.value = true;
};

const updateFilter = (payload) => {
  filters.value = { ...filters.value, ...payload };
};

const filteredRows = computed(() => {
  return items.value.filter((item) => {
    const q = search.value.toLowerCase();
    const matchSearch =
      item.id.toLowerCase().includes(q) || item.customer.toLowerCase().includes(q);

    const matchStatus =
      !filters.value.status ||
      filters.value.status === "Status" ||
      item.status === filters.value.status;

    const matchDate = !filters.value.date || item.date === filters.value.date;

    return matchSearch && matchStatus && matchDate;
  });
});

// ==============================
// SAVE UPDATE PESANAN
// ==============================
const handleSaveOrder = async ({ id, status, driver }) => {
  try {
    await OrdersAPI.updateStatus(id, status);

    if (status === "Dikirim" && driver) {
      const driverId = driverMap.value[driver]; // NAMA → ID

      if (!driverId) {
        console.error("Driver ID tidak ditemukan untuk:", driver);
        return;
      }

      await OrdersAPI.assignDriver(id, driverId);
    }

    await fetchOrders();
  } catch (e) {
    console.error("Gagal update pesanan", e);
  }
};

// ==============================
// MOUNT
// ==============================
onMounted(() => {
  fetchOrders();
  fetchDrivers();
});
</script>
