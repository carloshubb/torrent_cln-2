<script setup>
import AppLayout from './../layouts/AppLayout.vue'
import TorrentTable from '../Compenents/TorrentTable.vue'
import TorrentHead from '../Compenents/TorrentHead.vue'
import TorrentRules from '../Compenents/TorrentRules.vue'
import { reactive } from 'vue'
import { Head } from '@inertiajs/vue3'

</script>
<template>
  <Head :title="'Torrent Rules'" />
  <AppLayout> 
     <TorrentRules/>
    
  </AppLayout>
   
</template>
