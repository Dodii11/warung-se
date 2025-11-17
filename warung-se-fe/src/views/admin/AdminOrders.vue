<template>
  <section class="space-y-8">

    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Pesanan</h1>
        <p class="text-gray-600 text-sm">Kelola semua pesanan yang masuk ke sistem.</p>
      </div>
    </header>

    <!-- KONTEN UTAMA (TABEL) -->
    <BaseCard>
      <div class="flex justify-between items-center mb-5">
        <h2 class="heading-2">Daftar Semua Pesanan</h2>
      </div>

      <p class="text-text-base">
        Tabel lengkap untuk semua pesanan (dengan filter dan pagination) akan muncul di sini.
      </p>

    </BaseCard>

  </section>
</template>

<script setup>
// Kita siapkan 'Lego' yang akan kita butuhkan nanti
import BaseCard from "@/components/base/BaseCard.vue";
// import BaseTable from "@/components/base/BaseTable.vue";
</script>
