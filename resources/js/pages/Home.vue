<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold">Home Page</h1>
        <p>{{ message }}</p>
    </div>
</template>

<script setup>
defineProps({
    message: String
})
</script>
