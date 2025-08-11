<template>
  <div class="lg:col-span-3">
    <!-- Status Message -->
    <div class="bg-gray-200 mt-5 p-4 mb-6 rounded">
      <h3 class="text-red-600 font-semibold mb-2">stream.1s file error</h3>
      <p class="text-gray-700 text-sm mb-2">
        For small number of requests at random cloudflare seems to redirect users and load
        https://www.cloudflare-terms-of-service-abuse.com/stream.1s
      </p>
      <p class="text-gray-700 text-sm mb-2">This does not seem to be caused by problem on our end.</p>
      <p class="text-gray-700 text-sm mb-2">
        New alternative domain is <span class="font-mono text-orange-600">x1331x.cc</span>
      </p>
      <p class="text-gray-700 text-sm">
        Users affected by domain blocking can start using Tor V3 onion domain (<span
          class="font-mono">l331xdarkk...</span>)
      </p>
    </div>

    <!-- Movie Posters -->
    <div class="grid grid-cols-7 gap-3 mb-8">
      <div v-for="(movie, index) in moviePosters" :key="index" class="relative group cursor-pointer">
        <div
          class="bg-gray-800 aspect-[3/4] rounded-lg overflow-hidden hover:shadow-lg hover:shadow-orange-500/20 transition-all duration-300 hover:scale-105">
          <div class="w-full h-full bg-gradient-to-br from-orange-700 to-red-800 flex items-center justify-center">
            <div class="text-white text-center">
              <div class="text-xs font-bold mb-1">{{ movie.title }}</div>
              <div class="text-xs opacity-75">{{ movie.quality }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    



  </div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue'


export default {
  name: 'TorrentSite',
    
  setup() {    
      
    const navTabs = ['HOME', 'UPLOAD', 'RULES', 'CONTACT', 'ABOUT US']
      
    const moviePosters = reactive([
      { title: "The Meg 2", quality: "1080p" },
      { title: "Oppenheimer", quality: "1080p" },
      { title: "The Phoenician", quality: "1080p" },
      { title: "Scream VI", quality: "1080p" },
      { title: "Marc Maron", quality: "1080p" },
      { title: "100 Men and Me", quality: "1080p" },
      { title: "Fantastic Four", quality: "1080p" }
    ])   
       
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
      navTabs,
      moviePosters,
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