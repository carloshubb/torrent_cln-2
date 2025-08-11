<template>
  <div class="min-h-screen  bg-gray-300 text-white">
    <!-- Header -->
    <Header />

    <!-- Main Content Area -->
    <div class="flex flex-row w-full">
      <!-- LeftSpace -->
      <LeftSpace />
      <!-- Content -->
      
        
         <main class="w-233 bg-gray-300">
        <slot />
         </main>
        
      <!-- Sidebar -->
        <Sidebar />
      <!-- RightSpace -->
       
      <RightSpace />
    </div>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup>
import Header from '../Compenents/Layout/Header.vue'
import Sidebar from '../Compenents/Layout/Sidebar.vue'
import Footer from '../Compenents/Layout/Footer.vue'
//import Table from '../Compenents/TorrentTable.vue'
import LeftSpace from '../Compenents/Layout/LeftSpace.vue';
import RightSpace from '../Compenents/Layout/Rightuse.vue';
</script>