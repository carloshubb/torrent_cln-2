<template>
  <!-- Top Bar -->
  <div class="hidden md:flex min-h-[40px] bg-[#000] border-b-5 border-[#822a0b]">
    <div class="w-7xl mx-auto text-right">
      <div class="flex-1 items-center py-1">
        <a href="/login" v-if="!isLoggedIn" class="title text-red-600 hover:text-red-600">Login</a>
        <a v-if="isLoggedIn" class="title text-white hover:text-red-600" href="/uploads">Uploads</a>
        <a v-if="isLoggedIn" class="title text-white hover:text-red-600  ml-3" href="/logout">Logout</a>
      </div>
    </div>
  </div>
  <div class="bg-gray-800 backdrop-blur-sm border-b border-orange-500/50">
    <!-- Logo & Search Box -->
    <div class="justify-between md:flex md:w-7xl mx-auto items-center py-3 px-4 md:px-0 ">
      

      <div class="logo text-4xl font-bold text-white mb-2 md:mb-0 md:inline-block md:mr-4">
        1331<span class="text-orange-500">X</span>
      </div>
      <input type="text" placeholder="Search for torrents..." v-model="searchQuery" @keyup.enter="handleSearch"
        class="block w-full md:w-64 md:inline-block focus:outline-none bg-gray-800 border border-gray-600 text-white px-4 py-2 rounded focus:border-orange-500" />
    </div>

    <!-- Navbar -->
    <header class="flex justify-between items-center px-4 py-3 ">


      <!-- Desktop Nav -->
      <nav class="hidden md:grid w-7xl mx-auto grid-cols-5 gap-4">
        <a v-for="(tab, index) in navTabs" :key="index" :href=tab.slug :class="[
          'flex-1 px-10 py-3 transition-colors text-center',
          index === 0
            ? 'bg-gray-700 text-white border-l-3 border-orange-100 hover:bg-black-900'
            : 'bg-orange-600 text-white hover:bg-gray-700'
        ]">{{ tab.title }}</a>
      </nav>

      <!-- Mobile Menu Button -->
      <button class="md:hidden" @click="isMenuOpen = !isMenuOpen">
        ☰
      </button>
    </header>
  </div>
  <!-- Mobile Nav -->
  <nav v-if="isMenuOpen" class="md:hidden bg-gray-800 text-white px-4 py-2 space-y-2">
    <a v-for="(tab, index) in navTabs" :key="index" :href=tab.slug class="block">{{ tab.title }}</a>
  </nav>
</template>

<script setup>
import { ref } from "vue";
import { usePage } from '@inertiajs/vue3'
const isMenuOpen = ref(false);
const searchQuery = ref(""); // <-- define searchQuery
const page = usePage()
const isLoggedIn = ref(!!page.props.auth.user);




// Methods
const handleSearch = () => {
  if (searchQuery.value.trim()) {
    console.log('Searching for:', searchQuery.value)
    window.location.href = "/search/" + searchQuery.value + "/1/";
  }
}
const navTabs = [{ title: 'HOME', slug: "/" },
{ title: 'UPLOAD', slug: "/upload" },
{ title: 'RULES', slug: "/rules" },
{ title: 'CONTACT', slug: "/contact" },
{ title: 'ABOUT US', slug: "/about" }];

</script>