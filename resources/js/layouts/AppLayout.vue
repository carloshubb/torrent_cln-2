<template>
  <div class="flex flex-col min-h-screen  bg-gradient-to-r from-gray-300 to-gray-700 text-white">
    <!-- Header -->
    <Header />
    <!-- Main Layout -->
    <div class="flex flex-1">

      <!-- LeftSpace -->
      <LeftSpace />
      <div class="md:w-7xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-12 flex-1 gap-4">
          <!-- Content -->
          <main class="md:col-span-9">
            <slot />
          </main>

          <!-- Sidebar -->
          <Sidebar />
        </div>
        <!-- RightSpace -->
        <RightSpace />
      </div>


    </div>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import Header from '../Compenents/Layout/Header.vue'
import Sidebar from '../Compenents/Layout/Sidebar.vue'
import Footer from '../Compenents/Layout/Footer.vue'
import LeftSpace from '../Compenents/Layout/LeftSpace.vue';
import RightSpace from '../Compenents/Layout/Rightuse.vue';
import { ref } from "vue";

const isMenuOpen = ref(false);


</script>
