<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import AppLayout from './../layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, reactive, nextTick } from 'vue'
// Form data
const form = reactive({
  language: 'English',
  type: 'Choose Category',
  category: 'Choose One',
  tags: '',
  })


</script>

<template>

    <Head title="Your Torrents Uploads" />
    <AppLayout>
        <div class="max-w-4xl mx-auto p-6 bg-gray-100 text-black  min-h-screen">
           <!-- option -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select v-model="form.category"
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option>Choose One</option>
              <option>Action</option>
              <option>Comedy</option>
              <option>Drama</option>
              <option>Horror</option>
            </select>
            <p class="text-sm text-gray-500 mt-1">Please select which category best fits your torrent.</p>
          </div>
        </div>



    </AppLayout>
</template>
