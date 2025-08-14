<template>
  <div class="flex flex-col min-h-screen bg-gray-300 text-white">
    <!-- Header -->
    <Header />
    <!-- Main Content Area -->
    <div class="hidden flex flex-row w-full   bg-gradient-to-r from-gray-300 to-gray-700">
      <!-- LeftSpace -->
      <LeftSpace />
      <!-- Content -->
      <main class="w-233">
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