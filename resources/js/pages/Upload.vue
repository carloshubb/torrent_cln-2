<script setup>
import AppLayout from './../layouts/AppLayout.vue'
import TorrentAdminUpload from '../Compenents/TorrentAdminUpload.vue'
import { reactive, onMounted, ref } from 'vue'
import torrentService from '@/api/torrentService.js'
const categories = ref([]);
// Fetch function to get torrent data and update dashboard_data
async function fetchCategoryData() {
  try {
    const response = await torrentService.get('/torrents/categorydata');
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    categories.value = response.data.data;
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

onMounted(() => {
  fetchCategoryData();
});
</script>
<template>

  <AppLayout> 
     <TorrentAdminUpload  v-if="categories.length > 0" :categories = "categories"/>    
  </AppLayout>
   
</template>
