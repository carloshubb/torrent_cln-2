<template>
  <div class="px-2 md:px-0">
    <!-- Status Message -->
    <div class="bg-gray-200 mt-5 p-4 mb-6 rounded" v-if="page == 'dashboard'">
      <h3 class="text-red-600 font-semibold mb-2">Discover High-Quality Streaming with 1331x.cc: Your Ultimate Media Hub
      </h3>
      <p class="text-gray-700 text-sm mb-2">
        Welcome to <span class="font-mono text-orange-600">1331x.c</span>, your go-to destination for seamless streaming
        and online media enjoyment.
      </p>
      <p class="text-gray-700 text-sm mb-2">Whether you’re a casual viewer or a passionate movie buff, we provide a
        platform that prioritizes quality, speed, and reliability.
      </p>
      <p class="text-gray-700 text-sm mb-2">
        With 1331x.c, you can access a wide variety of content, including movies, TV shows, documentaries, and more, all
        available in high-definition.
      </p>
      <p class="text-gray-700 text-sm mb-2">
        Our site is designed for easy navigation, ensuring a hassle-free experience from start to finish.
      </p>
      <p class="text-gray-700 text-sm">
        Getting started with 1331x.cc is simple. Just visit our homepage, browse through our extensive library, and
        start streaming in seconds.
      </p>
      <p class="text-gray-700 text-sm">
        If you're facing any restrictions due to regional access, we provide Tor onion support for additional privacy
        and ease of access.
      </p>
    </div>

    <!-- Movie Posters -->
    <div class="relative w-full overflow-hidden" v-if="page == 'dashboard'">
      <!-- Slide container -->
      <div class="flex transition-transform duration-500"
        :style="{ transform: `translateX(-${currentIndex * (100 / visibleCount)}%)` }">
        <div v-for="(movie, index) in moviePosters" :key="index" class="flex-shrink-0"
          :style="{ width: `${100 / visibleCount}%` }">
          <div
            class="bg-gray-800 aspect-[3/5] rounded-lg overflow-hidden hover:shadow-lg hover:shadow-orange-500/20 transition-all duration-300 hover:scale-105">
            <div class="w-full h-full bg-gradient-to-br from-orange-700 to-red-800 flex items-center justify-center">
              <a :href="movie.link">
                <div class="text-white text-center">
                  <img :src="movie.image_url" alt="" class="h-48 w-auto mx-auto mb-2 rounded"
                  >                 
                  <div class="text-xs opacity-75">{{ movie.quality }}</div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Prev Button -->
      <button @click="prevSlide"
        class="absolute top-1/2 left-0 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-r">
        ‹
      </button>

      <!-- Next Button -->
      <button @click="nextSlide"
        class="absolute top-1/2 right-0 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-l">
        ›
      </button>
    </div>

  </div>
</template>

<script>
import { ref, reactive, onMounted, onBeforeUnmount } from 'vue'

const visibleCount = ref(6); // number of slides visible
const currentIndex = ref(0);
let slideInterval = null; // ///to store setInterval reference
export default {
  name: 'TorrentSite',
  props: {
    page: {
      type: String
    },
    images: {
      type: Object
    }
  },
  setup(props) {

    const navTabs = ['HOME', 'UPLOAD', 'RULES', 'CONTACT', 'ABOUT US']
    const page = props.page;

    const moviePosters = ref([])
    moviePosters.value = props.images[0].data.data ? props.images[0].data.data : [];

    const openLink = (link) => {
      console.log('Opening link:', link)
      // Implement external link logic
      // Open in new tab or navigate
    }

    function nextSlide() {
      if (currentIndex.value < moviePosters.value.length - visibleCount.value) {
        currentIndex.value++;
      } else {
        currentIndex.value = 0; // loop back to start
      }
    }

    function prevSlide() {
      if (currentIndex.value > 0) {
        currentIndex.value--;
      } else {
        currentIndex.value = moviePosters.value.length - visibleCount.value; // go to last group
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
      updateVisibleCount()
      window.addEventListener('resize', updateVisibleCount)
    })

    onBeforeUnmount(() => {
      stopAutoSlide();
      //
      window.removeEventListener('resize', updateVisibleCount)
    });

    function updateVisibleCount() {
      console.log(visibleCount.value);
      if (window.innerWidth < 640) { // Tailwind's `sm` breakpoint
        visibleCount.value = 3;
      } else {
        visibleCount.value = 6;
      }
    }


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