<template>
  <div class="lg:col-span-3">
    <!-- Status Message -->
    <div class="bg-gray-200 mt-5 p-4 mb-6 rounded" v-if="page == 'dashboard'">
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
    <div class="relative w-full overflow-hidden"  v-if="page == 'dashboard'">
    <!-- Slide container -->
    <div
      class="flex transition-transform duration-500"
      :style="{ transform: `translateX(-${currentIndex * (100 / visibleCount)}%)` }"
    >
      <div
        v-for="(movie, index) in moviePosters"
        :key="index"
        class="flex-shrink-0"
        :style="{ width: `${100 / visibleCount}%` }"
      >
        <div
          class="bg-gray-800 aspect-[3/5] rounded-lg overflow-hidden hover:shadow-lg hover:shadow-orange-500/20 transition-all duration-300 hover:scale-105"
        >
          <div class="w-full h-full bg-gradient-to-br from-orange-700 to-red-800 flex items-center justify-center">
            <a :href="movie.link">
            <div class="text-white text-center">
              <img
                :src="movie.image_url"
                alt=""
                class="h-48 w-auto mx-auto mb-2 rounded"
                @error="handleImgError($event)"
              />
              <div class="text-xs font-bold mb-1">{{ movie.title }}</div>
              <div class="text-xs opacity-75">{{ movie.quality }}</div>
            </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Prev Button -->
    <button
      @click="prevSlide"
      class="absolute top-1/2 left-0 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-r"
    >
      ‹
    </button>

    <!-- Next Button -->
    <button
      @click="nextSlide"
      class="absolute top-1/2 right-0 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-l"
    >
      ›
    </button>
  </div>

  </div>
</template>

<script>
import { ref, reactive, onMounted, onBeforeUnmount } from 'vue'

const visibleCount = 6; // number of slides visible
const currentIndex = ref(0);
let slideInterval = null; // to store setInterval reference
export default {
  name: 'TorrentSite',
  props: {
    page: {
      type: String
    },
    images :{
      type : Object
    }
  },
  setup(props) {

    const navTabs = ['HOME', 'UPLOAD', 'RULES', 'CONTACT', 'ABOUT US']
    const page = props.page;
    console.log(props.images[0].data.data);

    const moviePosters = ref([])
    moviePosters.value = props.images[0].data.data? props.images[0].data.data : [];

    const openLink = (link) => {
      console.log('Opening link:', link)
      // Implement external link logic
      // Open in new tab or navigate
    }

    function nextSlide() {
      if (currentIndex.value < moviePosters.value.length - visibleCount) {
        currentIndex.value++;
      } else {
        currentIndex.value = 0; // loop back to start
      }
    }

    function prevSlide() {
      if (currentIndex.value > 0) {
        currentIndex.value--;
      } else {
        currentIndex.value = moviePosters.value.length - visibleCount; // go to last group
      }
    }

    function startAutoSlide() {
      slideInterval = setInterval(() => {
        nextSlide();
      }, 3000); // change every 3 seconds
    }

    function stopAutoSlide() {
      clearInterval(slideInterval);
    }

    function handleImgError(e) {
      e.target.src = "fallback.jpg";
    }

    onMounted(() => {
      console.log('TorrentSite component mounted')
      startAutoSlide();
      // Initialize component, fetch data, etc.
    })

    onBeforeUnmount(() => {
      stopAutoSlide();
    });

    return {
      navTabs,
      moviePosters,
      page,
      currentIndex,
      visibleCount,
      prevSlide,
      nextSlide,
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