<template>
  <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse text-sm">

      <!-- HEADER -->
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th
            v-for="(col, index) in columns"
            :key="index"
            class="py-3 px-4 font-medium text-gray-700 whitespace-nowrap"
          >
            {{ col.label }}
          </th>

          <!-- Extra header if action slot exists -->
          <th
            v-if="$slots.action"
            class="py-3 px-4 font-medium text-gray-700 whitespace-nowrap"
          >
            Aksi
          </th>
        </tr>
      </thead>

      <!-- BODY -->
      <tbody>
        <tr
          v-for="(row, rowIndex) in rows"
          :key="rowIndex"
          class="border-b border-gray-100 hover:bg-gray-50 transition-colors"
        >
          <!-- Normal data cells -->
          <td
            v-for="(col, colIndex) in columns"
            :key="colIndex"
            class="py-3 px-4 whitespace-nowrap text-gray-700"
          >
            <slot :name="col.key" :row="row">
              {{ row[col.key] }}
            </slot>
          </td>

          <!-- Action slot (auto appears if slot action exists) -->
          <td
            v-if="$slots.action"
            class="py-3 px-4 whitespace-nowrap text-right"
          >
            <slot name="action" :row="row" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({
  columns: Array,
  rows: Array,
});
</script>
