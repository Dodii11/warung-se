<template>
    <section class="p-6 space-y-8">
      <!-- HEADER -->
      <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h1 class="heading-1">Dashboard</h1>
          <p class="text-gray-600 text-sm">Ringkasan aktivitas dan statistik sistem</p>
        </div>
      </header>

      <!-- STAT CARDS -->
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <BaseCard v-for="(stat, index) in stats" :key="index" class="flex flex-col justify-between">
          <div>
            <h3 class="text-sm font-medium text-gray-500">{{ stat.label }}</h3>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ stat.value }}</p>
          </div>

          <p
            class="text-sm mt-3 font-medium"
            :class="stat.change > 0 ? 'text-green-600' : 'text-red-600'"
          >
            {{ stat.change > 0 ? "+" : "" }}{{ stat.change }}% dari bulan lalu
          </p>
        </BaseCard>
      </div>

      <!-- RECENT TABLE -->
      <BaseCard>
        <div class="flex justify-between items-center mb-5">
          <h2 class="heading-2">Pesanan Terbaru</h2>

          <BaseButton
            variant="primary"
            size="sm"
            class=""
          >
            Semua Pesanan
            <ArrowRight class="w-4 h-4" />
          </BaseButton>
        </div>

        <!-- TABLE -->
        <BaseTable :columns="tableColumns" :rows="tableRows">
          <template #status="{ row }">
            <BaseStatusBadge :status="row.status" />
          </template>

          <template #action="{ row }">
            <RowActions :item="row" />
          </template>
        </BaseTable>
      </BaseCard>
    </section>
</template>

<script setup>
import BaseButton from "@/components/base/BaseButton.vue";
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseStatusBadge from "@/components/base/BaseStatusBadge.vue";
import RowActions  from "@/components/admin/dashboard/RowActions.vue";

import { stats, tableColumns, tableRows } from "@/data/dashboardData";
import { ArrowRight } from "lucide-vue-next";
</script>
