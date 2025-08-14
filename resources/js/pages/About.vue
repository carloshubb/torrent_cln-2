<script setup>
import AppLayout from './../layouts/AppLayout.vue'
import TorrentTable from '../Compenents/TorrentTable.vue'
import TorrentHead from '../Compenents/TorrentHead.vue'
import TorrentAbout from '../Compenents/TorrentAbout.vue'
import { reactive } from 'vue'
import { Head } from '@inertiajs/vue3'

</script>
<template>
  <Head :title="'About Us'" />
  <AppLayout> 
     <TorrentAbout/>
    
  </AppLayout>
   
</template>