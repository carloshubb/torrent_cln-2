<template>
  <header class="bg-gray-800 border-b border-gray-700">
    <!-- Top Bar -->
    <div class="min-h-[40px] bg-[#000] border-b-5 border-[#822a0b] items-center ">
    <div class="mx-auto w-full grid-cols-1 gap-10 container text-right ">
      <a href="" class="title text-white hover:text-red-600">Register</a>
      |
      <a href="" class="title text-red-600 hover:text-red-600">Login</a>
    </div>
  </div>
    <!-- Header -->
    <div class="bg-black/20 backdrop-blur-sm border-b border-orange-500/50">
      <div class="max-w-7xl mx-auto px-4">
          
        <!-- Main Header -->
        <div class="flex items-center justify-between py-4">
          <div class="text-4xl font-bold text-white">
            1331<span class="text-orange-500">X</span>
          </div>
          
          <div class="flex items-center space-x-2 flex-1 max-w-md mx-8">
            <input
              type="text"
              placeholder="Search for torrents..."
              v-model="searchQuery"
              class="flex-1 bg-gray-800 border border-gray-600 text-white px-4 py-2 rounded-l focus:outline-none focus:border-orange-500"
            />
            <button 
              @click="handleSearch"
              class="bg-orange-500 hover:bg-orange-800 text-white px-6 py-2 rounded-r transition-colors flex items-center"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
              SEARCH
            </button>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="w-full max-w-9/10 flex space-x-3 mb-3">
          <button 
            v-for="(tab, index) in navTabs" 
            :key="index"
            :class="[
              'px-23 py-3 transition-colors',
              index === 0 
                ? 'bg-gray-700 text-white border-l-3 border-orange-100 hover:bg-black-900' 
                : 'bg-orange-600 text-white hover:bg-gray-700'
            ]"
          >
            {{ tab }}
          </button>
        </nav>
      </div>
    </div>
  </header>
</template>

<script>
import { Link } from '@inertiajs/vue3'

import { ref, reactive, onMounted } from 'vue'

export default {
  name: 'TorrentSite',
  setup() {
    const searchQuery = ref('')
    
    const navTabs = ['HOME', 'UPLOAD', 'RULES', 'CONTACT', 'ABOUT US']
    
    const torrents = reactive([
      {
        name: "Jurassic World Rebirth 2025 1080p WEBRip DD5.1 x264-NeoNoir",
        se: 7,
        le: 4523,
        time: "7am Aug 5th",
        size: "2.5 GB",
        uploader: "NeoNoir"
      },
      {
        name: "Spider-Man Far From Home 2019 1080p x265-RapidX",
        se: 3,
        le: 1516,
        time: "6am Aug 7th",
        size: "3.2 GB", 
        uploader: "RapidX"
      },
      {
        name: "Wednesday S02 Season 2 P01 Part 1 2025 1080p NF WEBRip AAC.1 1080x1-RapG",
        se: 2,
        le: 1412,
        time: "11am Aug 4th",
        size: "2.8 GB",
        uploader: "RapGr"
      },
      {
        name: "The Fantastic Four First Steps [2025] 1080p HDCAM x264 DUAL AAC SUBS",
        se: 4,
        le: 448,
        time: "5pm Aug 2nd",
        size: "3.2 GB",
        uploader: "BHDOWNLQZ"
      },
      {
        name: "Together 2025 1080p SCREENER WEB-DL x264 AC3-AOC",
        se: 12,
        le: 796,
        time: "3am Aug 3rd",
        size: "6.5 GB",
        uploader: "atomicfusion"
      }
    ])

    const moviePosters = reactive([
      { title: "The Meg 2", quality: "1080p" },
      { title: "Oppenheimer", quality: "1080p" },
      { title: "The Phoenician", quality: "1080p" },
      { title: "Scream VI", quality: "1080p" },
      { title: "Marc Maron", quality: "1080p" },
      { title: "100 Men and Me", quality: "1080p" },
      { title: "Fantastic Four", quality: "1080p" }
    ])

    const browseCategories = [
      'Trending Torrents',
      'Movie library', 
      'Top 100 Torrents',
      'Anime',
      'Applications',
      'Documentaries',
      'Games',
      'Movies',
      'Music',
      'Other',
      'Television',
      'XXX'
    ]

    const externalLinks = [
      '1337x Status',
      '1337x Chat',
      'Torrent9',
      'uTrix',
      'Njalla',
      'PRQ',
      'Limetorrents',
      'TorrentFunk',
      'ThePornDude',
      'Torlock'
    ]

    // Methods
    const handleSearch = () => {
      if (searchQuery.value.trim()) {
        console.log('Searching for:', searchQuery.value)
        // Implement search logic here
        // You can emit an event or call an API
      }
    }

    const viewTorrent = (torrent) => {
      console.log('Viewing torrent:', torrent.name)
      // Implement torrent view logic
      // Navigate to torrent details page
    }

    const browseCategory = (category) => {
      console.log('Browsing category:', category)
      // Implement category browsing logic
      // Navigate to category page or filter torrents
    }

    const openLink = (link) => {
      console.log('Opening link:', link)
      // Implement external link logic
      // Open in new tab or navigate
    }

    onMounted(() => {
      console.log('TorrentSite component mounted')
      // Initialize component, fetch data, etc.
    })

    return {
      searchQuery,
      navTabs,
      torrents,
      moviePosters,
      browseCategories,
      externalLinks,
      handleSearch,
      viewTorrent,
      browseCategory,
      openLink
    }
  }
}
</script>

<style scoped>
/* Add any component-specific styles here if needed */
.bg-gray-750 {
  background-color: rgb(55, 65, 81, 0.5);
}
</style>