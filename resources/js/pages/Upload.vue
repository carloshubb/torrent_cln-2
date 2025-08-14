<script setup>
import AppLayout from './../layouts/AppLayout.vue'
import TorrentTable from '../Compenents/TorrentTable.vue'
import TorrentHead from '../Compenents/TorrentHead.vue'
import TorrentAdminUpload from '../Compenents/TorrentAdminUpload.vue'
import { reactive } from 'vue'

</script>
<template>
  <router-view></router-view>
  <AppLayout> 
     <TorrentAdminUpload/>    
  </AppLayout>
   
</template>
