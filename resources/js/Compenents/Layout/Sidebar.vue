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
          <div class="w-4 h-4 bg-orange-600 rounded-sm mr-3 flex items-center justify-center">
            <div class="w-2 h-2 bg-white rounded-sm"></div>
          </div>
          {{ category.title }}
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

    // const browseCategories = [
    //   'Trending Torrents',
    //   'Movie library', 
    //   'Top 100 Torrents',
    //   'Anime',
    //   'Applications',
    //   'Documentaries',
    //   'Games',
    //   'Movies',
    //   'Music',
    //   'Other',
    //   'Television',
    //   'XXX'
    // ]
    const browseCategories = [
      {title:'Trending Torrents',slug:'trending'},
      {title:'Movie library',slug:'movie-library'},
      {title:'Top 100 Torrents',slug:'top-100'},
      {title:'Anime',slug:'Anime'},
      {title:'Applications',slug:'Apps'},
      {title:'Documentaries',slug:'Documentaries'},
      {title:'Games',slug:'Games'},
      {title:'Movies',slug:'Movies'},
      {title:'Music',slug:'Music'},
      {title:'Other',slug:'Other'},
      {title:'Television',slug:'TV'},
      {title:'XXX',slug:'XXX'},
      
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
      else if(category.slug == 'movie-library'){
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