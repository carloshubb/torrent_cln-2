<template>
  <div class="space-y-6 ml-8 w-70 mt-5">
    <!-- Browse Torrents -->
    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl">
      <div class="bg-gradient-to-r from-orange-500 to-gray-500 px-4 py-3">
        <h3 class="text-white font-bold">BROWSE TORRENTS</h3>
      </div>
      <div class="p-4 space-y-2">
        <div v-for="(category, index) in browseCategories" :key="index"
          class="flex items-center text-gray-300 hover:text-orange-400 cursor-pointer transition-colors py-1"
          @click="browseCategory(category)">
          <div class="w-4 h-4  rounded-sm mr-3 flex items-center justify-center">
            <div> {{ category.icon}}</div>
          </div>
          {{ category.title}}
        </div>
      </div>
    </div>

    <!-- Links -->
    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl">
      <div class="bg-gradient-to-r from-orange-500 to-gray-500 px-4 py-3">
        <h3 class="text-white font-bold">1331X LINKS</h3>
      </div>
      <div class="p-4 space-y-2">
        <div v-for="(link, index) in externalLinks" :key="index"
          class="text-orange-400 hover:text-orange-300 cursor-pointer transition-colors py-1" @click="openLink(link)">
          » {{ link }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

import { ref, reactive, onMounted } from 'vue'

export default {
  name: 'TorrentSite',
  setup() {
    const browseCategories = [
      {title:'Trending Torrents',icon:'📈',slug:'trending'},
      {title:'Movie library',icon:'📚',slug:'MovieLibrary'},
      {title:'Top 100 Torrents',icon:'⭐',slug:'top-100'},
      {title:'Anime',icon:'🎌',slug:'Anime'},
      {title:'Applications',icon:'💾',slug:'Apps'},
      {title:'Documentaries',icon:'📋',slug:'Documentaries'},
      {title:'Games',icon:'🎮',slug:'Games'},
      {title:'Movies',icon:'🎬',slug:'Movies'},
      {title:'Music',icon:'🎵',slug:'Music'},
      {title:'Other',icon:'📁',slug:'Other'},
      {title:'Television',icon:'📺',slug:'TV'},
      {title:'XXX',icon:'🔞',slug:'XXX'},
      
    ]
    const externalLinks = [
      '1331x Status',
      '1331x Chat',
      'Torrent9',
      'uTrix',
      'Njalla',
      'PRQ',
      'Limetorrents',
      'TorrentFunk',
      'ThePornDude',
      'Torlock'
    ]




    const browseCategory = (category) => {
      console.log('Browsing category:', category)
      if(category.slug == 'trending' || category.slug == 'top-100'){
         window.location.href = `/${category.slug}`;       
      } 
      else if(category.slug == 'movielibrary'){
         window.location.href = `/${category.slug}/1/`;       
      }
      else{
         window.location.href = `/cat/${category.slug}/1/`;       
      }
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
      browseCategories,
      externalLinks,
      browseCategory,
      openLink
    }
  }
}
</script>

<style scoped>
/* Add any component-specific styles here if needed */
.bg-gray-750 {
  background-color: rgba(168, 174, 185, 0.5);
}
</style>