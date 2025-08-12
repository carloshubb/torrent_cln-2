<template>
  <div class="lg:col-span-3">
    <!-- Popular Torrents Section -->
    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl mt-6">
      <div class="bg-gradient-to-r from-orange-400 to-red-500 px-4 py-3 flex items-center">
        <!-- <svg class="w-5 h-5 mr-2 text-white" fill="black" viewBox="0 0 20 20">
          <path
            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
          </path>
        </svg> -->
        <h2 class="text-white font-bold">⭐⭐⭐⭐⭐{{ head_title }}</h2>
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
                    <a :href="`/sub/${torrent.sub_category_id}/0/`">
                      <div class="w-6 h-6 bg-orange-600 rounded mr-3 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                          </path>
                        </svg>
                      </div>
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
    console.log(props.page);

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
        // Simulate loading new torrents for the selected page
        // Replace with real API call to fetch torrents for the page
        console.log(`Load torrents for page: ${page}`)
        // For demo, just keep old torrents or you could do:
        // torrents.value = fetchTorrentsForPage(page)
      }
    }

    onMounted(() => {
      console.log('TorrentSite mounted, currentPage:', currentPage.value)
    })

    return {
      currentPage,
      lastPage,
      torrents,
      page_type,
      formatApprovedAt,
      viewTorrent,
      onPageChange,
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
</style>
