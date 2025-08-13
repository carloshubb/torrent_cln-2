<template>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'trending'">

    <!-- First row -->
    <div class="flex gap-2 bg-gray-300 p-2 rounded">
      <button class="flex items-center gap-2 bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
        <i class="fas fa-chart-line"></i>
        All Trending Today
      </button>
      <button class="flex items-center gap-2 bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
        <i class="fas fa-chart-line"></i>
        All Trending This Week
      </button>
    </div>

    <!-- Second row -->
    <div class="flex flex-wrap gap-2 bg-gray-300 p-2 rounded">
      <button class="btn-icon"><i class="fas fa-film"></i> Trending Movies</button>
      <button class="btn-icon"><i class="fas fa-tv"></i> Trending TV</button>
      <button class="btn-icon"><i class="fas fa-gamepad"></i> Trending Games</button>
      <button class="btn-icon"><i class="fab fa-windows"></i> Trending Apps</button>
      <button class="btn-icon"><i class="fas fa-music"></i> Trending Music</button>
      <button class="btn-icon"><i class="fas fa-video"></i> Trending Documentaries</button>
      <button class="btn-icon"><i class="fas fa-mask"></i> Trending Anime</button>
      <button class="btn-icon"><i class="fas fa-ellipsis-h"></i> Trending Other</button>
      <button class="btn-icon"><i class="fas fa-exclamation-circle"></i> Trending XXX</button>
    </div>

  </div>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'top'">

    <!-- Second row -->
    <div class="flex flex-wrap gap-2 bg-gray-300 p-2 rounded">
      <button class="btn-icon"><i class="fas fa-film"></i> Top 100 Movies</button>
      <button class="btn-icon"><i class="fas fa-tv"></i> Top 100 TV</button>
      <button class="btn-icon"><i class="fas fa-gamepad"></i> Top 100 Games</button>
      <button class="btn-icon"><i class="fab fa-windows"></i> Top 100 Apps</button>
      <button class="btn-icon"><i class="fas fa-music"></i> Top 100 Music</button>
      <button class="btn-icon"><i class="fas fa-video"></i> Top 100 Documentaries</button>
      <button class="btn-icon"><i class="fas fa-mask"></i> Top 100 Anime</button>
      <button class="btn-icon"><i class="fas fa-ellipsis-h"></i> Top 100 Other</button>
      <button class="btn-icon"><i class="fas fa-exclamation-circle"></i> Top 100 XXX</button>
    </div>

  </div>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'Anime'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for Anime</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button class="btn-icon"><i class="fas fa-mask"></i> Anime</button>
        <button class="btn-icon"><i class="fas fa-train"></i> Dual Audio</button>
        <button class="btn-icon"><i class="fas fa-film"></i> Dubbed</button>
        <button class="btn-icon"><i class="fas fa-video"></i> Raw</button>
        <button class="btn-icon"><i class="fas fa-closed-captioning"></i> Subbed</button>
      </div>
    </div>
  </div>
  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'Apps'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for Anime</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button class="btn-icon"><i class="fab fa-android"></i> Android</button>
        <button class="btn-icon"><i class="fab fa-apple"></i> iOS</button>
        <button class="btn-icon"><i class="fab fa-linux"></i> Linux</button>
        <button class="btn-icon"><i class="fas fa-laptop"></i> Mac</button>
        <button class="btn-icon"><i class="fas fa-ellipsis-h"></i> Other</button>
        <button class="btn-icon"><i class="fas fa-desktop"></i> PC Software</button>
      </div>
    </div>
  </div>
  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'Documentaries'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for Documentaries</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button class="btn-icon"><i class="fas fa-solid fa-video"></i> Documentary</button>
      </div>
    </div>
  </div>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'Games'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for Games</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button class="btn-icon"><i class="fas fa-gamepad"></i> 3DS</button>
        <button class="btn-icon"> <i class="fas fa-dice-d6"></i> Dreamcast</button>
        <button class="btn-icon"><i class="fas fa-tablet-alt"></i> DS</button>
        <button class="btn-icon"><i class="fas fa-cube"></i> GameCube</button>
        <button class="btn-icon"> <i class="fab fa-windows"></i> PC Game</button>
        <button class="btn-icon"> <i class="fab fa-playstation"></i> PS1</button>
        <button class="btn-icon"> <i class="fab fa-playstation"></i> PS2</button>
        <button class="btn-icon"> <i class="fab fa-playstation"></i> PS3</button>
        <button class="btn-icon"> <i class="fab fa-playstation"></i> PS4</button>
        <button class="btn-icon"><i class="fas fa-compact-disc"></i> PSP</button>
        <button class="btn-icon"><i class="fas fa-gamepad"></i> Switch</button>
        <button class="btn-icon"><i class="fas fa-gamepad"></i> Wii</button>
        <button class="btn-icon"><i class="fab fa-xbox"></i> Xbox</button>
        <button class="btn-icon"><i class="fab fa-xbox"></i> Xbox360</button>
      </div>
    </div>
  </div>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'Movies'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for Movies</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button class="btn-icon"><i class="fas fa-cube"></i> 3D</button>
        <button class="btn-icon"><i class="fas fa-film"></i> Bollywood</button>
        <button class="btn-icon"><i class="fas fa-video"></i> Divx/Xvid</button>
        <button class="btn-icon"><i class="fas fa-language"></i> Dubs/Dual Audio</button>
        <button class="btn-icon"><i class="fas fa-compact-disc"></i> DVD</button>
        <button class="btn-icon"><i class="fas fa-photo-video"></i> h.264/x264</button>
        <button class="btn-icon"><i class="fas fa-highlighter"></i> HD</button>
        <button class="btn-icon"><i class="fas fa-photo-video"></i> HEVC/x265</button>
        <button class="btn-icon"><i class="fas fa-file-video"></i> Mp4</button>
        <button class="btn-icon"><i class="fas fa-compact-disc"></i> SVCD/VCD</button>
        <button class="btn-icon"><i class="fas fa-tv"></i> UHD</button>
      </div>
    </div>
  </div>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'Music'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for Music</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button class="btn-icon"><i class="fas fa-music"></i> AAC</button>
        <button class="btn-icon"><i class="fas fa-compact-disc"></i> Album</button>
        <button class="btn-icon"><i class="fas fa-box"></i> Box Set</button>
        <button class="btn-icon"><i class="fas fa-microphone"></i> Concerts</button>
        <button class="btn-icon"><i class="fas fa-book"></i> Discography</button>
        <button class="btn-icon"><i class="fas fa-compact-disc"></i> DVD</button>
        <button class="btn-icon"><i class="fas fa-volume-mute"></i> Lossless</button>
        <button class="btn-icon"><i class="fas fa-headphones"></i> MP3</button>
        <button class="btn-icon"><i class="fas fa-question"></i> Other</button>
        <button class="btn-icon"><i class="fas fa-radio"></i> Radio</button>
        <button class="btn-icon"><i class="fas fa-dot-circle"></i> Single</button>
        <button class="btn-icon"><i class="fas fa-video"></i> Video</button>
      </div>
    </div>
  </div>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'Other'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for Other</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button class="btn-icon"><i class="fas fa-headphones"></i> Audiobook</button>
        <button class="btn-icon"><i class="fas fa-mask"></i> Comics</button>
        <button class="btn-icon"><i class="fas fa-book-open"></i> E-Books</button>
        <button class="btn-icon"><i class="fas fa-gamepad"></i> Emulation</button>
        <button class="btn-icon"><i class="fas fa-images"></i> Images</button>
        <button class="btn-icon"><i class="fas fa-mobile-alt"></i> Mobile Phone</button>
        <button class="btn-icon"><i class="fas fa-code"></i> Nulled Script</button>
        <button class="btn-icon"><i class="fas fa-cog"></i> Other</button>
        <button class="btn-icon"><i class="fas fa-volume-up"></i> Sounds</button>
        <button class="btn-icon"><i class="fas fa-graduation-cap"></i> Tutorials</button>
      </div>
    </div>
  </div>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'TV'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for TV</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button class="btn-icon"><i class="fas fa-smile"></i> Cartoon</button>
        <button class="btn-icon"><i class="fas fa-film"></i> Divx/Xvid</button>
        <button class="btn-icon"><i class="fas fa-compact-disc"></i> DVD</button>
        <button class="btn-icon"><i class="fas fa-fire"></i> HD</button>
        <button class="btn-icon"><i class="fas fa-compress"></i> HEVC/x265</button>
        <button class="btn-icon"><i class="fas fa-video"></i> SD</button>
        <button class="btn-icon"><i class="fas fa-clock"></i> SVCD/VCD</button>
      </div>
    </div>
  </div>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'XXX'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for XXX</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button class="btn-icon"><i class="fas fa-gamepad"></i> Games</button>
        <button class="btn-icon"><i class="fas fa-users"></i> Hentai</button>
        <button class="btn-icon"><i class="fas fa-newspaper"></i> Magazine</button>
        <button class="btn-icon"><i class="fas fa-camera"></i> Picture</button>
        <button class="btn-icon"><i class="fas fa-video"></i> Video</button>
      </div>
    </div>
  </div>
  <div class="lg:col-span-3 ">
    <!-- Popular Torrents Section -->
    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl mt-6">
      <div class="bg-gradient-to-r from-orange-400 to-red-500 px-4 py-3 flex items-center">
        <!-- <svg class="w-5 h-5 mr-2 text-white" fill="black" viewBox="0 0 20 20">
          <path
            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
          </path>
        </svg> -->
        <i class="fi fi-sr-clapperboard-play"></i>
        <!-- <h2 class="text-white font-bold ">⭐⭐⭐⭐⭐    {{ head_title }}</h2> -->
         <h2 class="text-white font-bold" v-if="page_type == 'trending'"> {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'search'"> {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'dashboard'"> {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'top'">⭐ {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'cat' && torrent_type == 'Anime'">🎌 {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'cat' && torrent_type == 'Apps'">💾 {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'cat' && torrent_type == 'Documentaries'">📋 {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'cat' && torrent_type == 'Games'">🎮 {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'cat' && torrent_type == 'Movies'">🎬 {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'cat' && torrent_type == 'Music'">🎵 {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'cat' && torrent_type == 'Other'">📁 {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'cat' && torrent_type == 'TV'">📺 {{ head_title }}</h2>
         <h2 class="text-white font-bold" v-if="page_type == 'cat' && torrent_type == 'XXX'">🔞{{ head_title }}</h2>

      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-700">
            <tr>
              <th class="text-left px-4 py-3 text-gray-300 font-semibold">name</th>
              <th class="text-center px-4 py-3 text-gray-300 font-semibold">se</th>
              <th class="text-center px-4 py-3 text-gray-300 font-semibold">le</th>
              <th class="text-center px-4 py-3 text-gray-300 font-semibold">time</th>
              <th class="text-center px-4 py-3 text-gray-300 font-semibold">size</th>
              <th class="text-center px-4 py-3 text-gray-300 font-semibold">uploader</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(torrent, index) in torrents" :key="index"
              class="border-b border-gray-700 hover:bg-gray-750 transition-colors cursor-pointer"
              @click="viewTorrent(torrent)">
              <td class="px-4 py-3">
                <div class="flex items-center justify-between w-full">
                  <!-- Left side: icon + name -->
                  <div class="flex items-center">
                    <a :href="`/sub/${torrent.subcategory_id}/0/`">
                      <button class="btn-icon-tr" v-if="torrent.subcategory"><i :class="`${torrent.subcategory.icon}`"></i></button>
                    </a>
                    <a :href="`/torrent/${torrent.id}/${torrent.slug}/`"
                      class="text-gray-300 hover:text-orange-400 transition-colors">
                      {{ torrent.name }}
                    </a>
                  </div>

                  <!-- Right side: badge -->
                  <span v-if="torrent.comments_count"
                    class="bg-white text-orange-600 rounded text-xs font-semibold px-1.5 py-0.5">
                    {{ torrent.comments_count }}
                  </span>
                </div>
              </td>
              <td class="text-center px-4 py-3">
                <span class="bg-green-600 text-white px-2 py-1 rounded text-sm font-bold">
                  {{ torrent.seeders }}
                </span>
              </td>
              <td class="text-center px-4 py-3">
                <span class="bg-red-600 text-white px-2 py-1 rounded text-sm font-bold">
                  {{ torrent.leechers }}
                </span>
              </td>
              <td class="text-center px-4 py-3 text-gray-400 text-sm">
                {{ formatApprovedAt(torrent.approved_at) }}
              </td>
              <td class="text-center px-4 py-3 text-gray-400 text-sm">
                {{ torrent.size_formatted }}
              </td>
              <td class="text-center px-4 py-3">
                <a :href="torrent.uploader">
                  <span class="text-orange-400 hover:text-orange-300 transition-colors">
                    {{ torrent.uploader?.split('/')[2] }}
                  </span>
                </a>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination component -->
        <TorrentPagination
          v-if="page_type.toLowerCase() !== 'dashboard' && page_type.toLowerCase() !== 'trending' && page_type.toLowerCase() !== 'top'"
          :currentPage="currentPage" :lastPage="lastPage" @page-changed="onPageChange" />
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import TorrentPagination from '../Compenents/TorrentPagination.vue'
dayjs.extend(relativeTime)

export default {
  name: 'TorrentSite',
  props: {
    torrents: {
      type: Object, // Expecting { data: Array, lastPage: Number } or similar
      required: true
    },
    head_title: {
      type: String,
      required: true
    },
    page: {
      type: String,
      required: true
    }
  },

  setup(props) {
    const currentPage = ref(props.torrents.current_page || 1)
    const lastPage = ref(props.torrents.last_page || 1) // default to 7 if not passed
    const torrents = ref(props.torrents.data)
    const page_type = ref(props.page)
    const pathSegments = window.location.pathname
      .split('/')
      .filter(segment => segment); // remove empty entries    
    const torrent_type = pathSegments[1]; // "Anime"

    const formatApprovedAt = (dateString) => {
      const date = dayjs(dateString)
      const now = dayjs()
      if (date.isSame(now, 'day')) {
        return date.format('h:mma')
      } else {
        return date.format('ha MMM. Do')
      }
    }

    const viewTorrent = (torrent) => {
      console.log('Viewing torrent:', torrent.name)
      // Navigate or show detail logic here
    }

    const onPageChange = (page) => {
      if (page >= 1 && page <= lastPage.value) {
        currentPage.value = page
      }
    }

    onMounted(() => {
      //console.log(torrent_type);

    })

    return {
      currentPage,
      lastPage,
      torrents,
      page_type,
      formatApprovedAt,
      viewTorrent,
      onPageChange,
      torrent_type,
      head_title: props.head_title
    }
  },

  components: {
    TorrentPagination
  }
}
</script>

<style scoped>
.bg-gray-750 {
  background-color: rgba(55, 65, 81, 0.5);
}

.btn-icon {
  display: inline-flex;
  /* keeps icon + text aligned */
  align-items: center;
  /* vertical center */
  justify-content: center;
  /* horizontal center */
  gap: 0.5rem;
  /* space between icon and text */
  background-color: #e65100;
  /* orange background */
  color: white;
  /* text color */
  padding: 0.25rem 0.75rem;
  /* vertical / horizontal padding */
  border-radius: 0.25rem;
  /* rounded corners */
  cursor: pointer;
  /* pointer on hover */
  font-size: 14px;
  /* text size */
  text-align: center;
  /* centers text if wrapped */
  border: none;
  /* remove default button border */
}

.btn-icon:hover {
  background-color: #bf360c;
  /* darker orange on hover */
}


.btn-icon-tr {
  display: inline-flex;
  /* keeps icon + text aligned */
  align-items: center;
  /* vertical center */
  justify-content: center;
  /* horizontal center */
  gap: 0.5rem;
  /* space between icon and text */
  /* background-color: #e65100; */
  /* orange background */
  color: white;
  /* text color */
  padding: 0.45rem 0.25rem;
  /* vertical / horizontal padding */
  border-radius: 0.25rem;
  /* rounded corners */
  cursor: pointer;
  /* pointer on hover */
  font-size: 22px;
  /* text size */
  text-align: center;
  /* centers text if wrapped */
  border: none;
  /* remove default button border */
  margin-right: 10px;
}

.btn-icon-tr:hover {
  text-decoration: underline;
  /* darker orange on hover */
}
</style>
