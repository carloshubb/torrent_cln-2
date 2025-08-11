<template>
  <div>
    <h2>Category: {{ categoryName }}</h2>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
const route = useRoute()
const categoryName = route.params.name
</script>
