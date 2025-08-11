<template>
  <div class="product-card">
    <h3>{{ product.name }}</h3>
    <p>Category: {{ product.category }}</p>
  </div>
</template>

<script setup>
defineProps(['product'])
</script>

<style scoped>
.product-card {
  padding: 10px;
  border: 1px solid #ccc;
  margin-bottom: 10px;
}
</style>
