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


  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat' && torrent_type == 'App'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for Applications</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button v-for="(subcategory, index) in subcategories" :key="index" class="btn-icon"
          @click="goToSubcategory(subcategory)">
          <i :class="subcategory.icon"></i> {{ subcategory.name }}
        </button>
      </div>
    </div>
  </div>

  <div class="space-y-4 p-4 bg-gray-900" v-if="page_type == 'cat'">
    <!-- Second row -->
    <div class="gap-2 bg-gray-300 p-2 rounded">
      <h2 class="text-orange-600 font-bold text-lg mb-2">Subcategories for {{ torrent_type }}</h2>
      <div class="p-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded flex flex-wrap gap-2">
        <button v-for="(subcategory, index) in subcategories" :key="index" class="btn-icon"
          @click="goToSubcategory(subcategory)">
          <i :class="subcategory.icon"></i> {{ subcategory.name }}
        </button>
      </div>
    </div>
  </div>

  <div class="lg:col-span-3 ">
    <!-- Popular Torrents Section -->
    <div class="featured-list bg-gray-800 rounded-lg overflow-hidden shadow-xl mt-6">
      <div class="featured-heading bg-gradient-to-r from-orange-400 to-red-500 px-4 py-3 flex items-center">
        <h2 class="text-white font-bold">
          <span class="featured-icon">
            <i :class=icon></i>
          </span>
          {{ head_title }}
        </h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-700">
            <tr>
              <th class="text-left px-4 py-1 text-gray-300 font-semibold">name</th>
              <th class="text-center px-4 py-1 text-gray-300 font-semibold">se</th>
              <th class="text-center px-4 py-1 text-gray-300 font-semibold">le</th>
              <th class="text-center px-4 py-1 text-gray-300 font-semibold">time</th>
              <th class="text-center px-4 py-1 text-gray-300 font-semibold">size</th>
              <th class="text-center px-4 py-1 text-gray-300 font-semibold">uploader</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(torrent, index) in torrents" :key="index"
              class="border-b border-gray-700 hover:bg-gray-750 transition-colors cursor-pointer text-xs"
              @click="viewTorrent(torrent)">
              <td class="px-2 py-3">
                <div class="flex items-center justify-between w-full">
                  <!-- Left side: icon + name -->
                  <div class="flex items-center">
                    <a :href="`/sub/${torrent.subcategory_id}/0/`">
                      <button class="" v-if="torrent.subcategory"><i
                          :class="`${torrent.subcategory.icon}`"></i></button>
                    </a>
                    <a :href="`/torrent/${torrent.id}/${torrent.slug}/`"
                      class="text-gray-300 hover:text-orange-400 transition-colors ml-3">
                      {{ torrent.name }}
                    </a>
                  </div>

                  <!-- Right side: badge -->
                  <span v-if="torrent.comments_count"
                    class="bg-gray-500 text-black-900 rounded text-xs font-semibold px-2">
                    {{ torrent.comments_count }}
                  </span>
                </div>
              </td>
              <td class="text-center px-2 py-2">
                <span class="bg-green-600 text-white px-1 text-xs rounded ">
                  {{ torrent.seeders }}
                </span>
              </td>
              <td class="text-center px-2 py-2">
                <span class="bg-red-800 text-white px-1 text-xs rounded ">
                  {{ torrent.leechers }}
                </span>
              </td>
              <td class="text-center px-2 py-2 text-gray-400 ">
                {{ formatApprovedAt(torrent.approved_at) }}
              </td>
              <td class="text-center px-2 py-2 text-gray-400 ">
                {{ torrent.size_formatted }}
              </td>
              <td class="text-center px-2 py-2">
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
    icon: {
      type: String,
      default: 'flaticon-top' // Default icon if not provided
    },
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
    const currentPage = ref(props.torrents.data.current_page || 1)
    const lastPage = ref(props.torrents.data.last_page || 1) // default to 7 if not passed
    const torrents = ref(props.torrents.data.data)
    const page_type = ref(props.page)
    const subcategories = props.torrents.subcategories ? ref(props.torrents.subcategories) : null
    const pathSegments = window.location.pathname
      .split('/')
      .filter(segment => segment); // remove empty entries    
    const torrent_type = pathSegments[1]; // "Anime"
    console.log(props.torrents, currentPage, torrents);

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
    const goToSubcategory = (subcategory) => {
      window.location.href = `/sub/${subcategory.id}/0/`;
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
      subcategories,
      goToSubcategory,
      icon: props.icon,
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

/*  */
.featured-list .featured-heading {
  line-height: 30px;
  padding-top: 10px;
  padding-bottom: 10px;
}

.featured-heading {
  background-color: #d1d1d1;
  border-radius: 4px 4px 0 0;
  padding: 0 13px 0 68px;
  position: relative;
}


.featured-icon {
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 50px;
  padding: 0 10px;
  display: block;
  color: #fff;
  border-top-left-radius: 3px;
  background-color: #d63600;
}

.featured-icon:after {
  position: absolute;
  right: -8px;
  top: 50%;
  content: "";
  height: 0;
  width: 0;
  margin-top: -8px;
  border-bottom: 8px solid transparent;
  border-left: 8px solid #d63600;
  border-top: 8px solid transparent;
}

.featured-heading .featured-icon i {
  left: 50%;
  margin-left: -12px;
  margin-top: -12px;
  position: absolute;
  top: 50%;
  line-height: 1;
  font-size: 22px;
}

</style>
