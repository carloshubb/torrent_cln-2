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
    <div v-if="moviePosters.length" class="grid grid-cols-7 gap-3 mb-8">
      <div v-for="(movie, index) in moviePosters" :key="index" class="relative group cursor-pointer">
        <div
          class="bg-gray-800 aspect-[3/4] rounded-lg overflow-hidden hover:shadow-lg hover:shadow-orange-500/20 transition-all duration-300 hover:scale-105">
          <div class="w-full h-full bg-gradient-to-br from-orange-700 to-red-800 flex items-center justify-center">
            <div class="text-white text-center">
              <img
                :src="movie.img"
                alt=""
                class="h-48 w-auto mx-auto mb-2 rounded"
                @error="handleImgError($event)"
              />
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
      { title: "The Meg 2", quality: "1080p", img: "//lx1.dyncdn.cc/cdn/83/83841d458d96af45ca4bfcf7cb6e7a39.jpg" },
      { title: "Oppenheimer", quality: "1080p", img: "//lx1.dyncdn.cc/cdn/6a/6ab59873a519d3ee0b4f19d17e7a24d2.jpg" },
      { title: "The Phoenician", quality: "1080p", img: "//lx1.dyncdn.cc/cdn/eb/eb0191fb271b70f86e87e59375255094.jpg" },
      { title: "Scream VI", quality: "1080p", img: "//lx1.dyncdn.cc/cdn/17/179cab5391f331d881226804b5b055dd.jpg" },
      { title: "Marc Maron", quality: "1080p", img: "//lx1.dyncdn.cc/cdn/0d/0d288e692bd79103666bd69abdb6a535.jpg" },
      { title: "100 Men and Me", quality: "1080p", img: "//lx1.dyncdn.cc/cdn/da/dad7642f00b0854080583217fd317085.jpg" },
      { title: "Fantastic Four", quality: "1080p", img: "//lx1.dyncdn.cc/cdn/c8/c8722414c03e4c3e30295d24c07c4e89.jpg" }
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