<template>

  <Head :title=$page.props.title />
  <AppLayout>
    <div class="max-w-7xl mx-auto py-4" v-if="torrent">
      <div class="flex gap-6">
        <!-- Main Content -->
        <div class="flex-1">
          <!-- Title -->
          <div class="bg-gray-700 px-4 py-2 rounded">
            <h1 class="text-lg font-semibold">{{ torrent.name }}</h1>
          </div>

          <!-- Torrent Info -->
          <div class="bg-gray-800 rounded mb-4">
            <div class="grid grid-cols-2 gap-4 p-4 text-sm">
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-gray-400">Category:</span>
                  <span>{{ torrent.detail.category }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Type:</span>
                  <span>{{ torrent.detail.type }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Language:</span>
                  <span>{{ torrent.detail.language }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Total Size:</span>
                  <span>{{ torrent.size_formatted }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Uploaded By:</span>
                  <span class="text-green-400">{{ torrent.detail.uploader }}</span>
                </div>
              </div>
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-gray-400">Downloads:</span>
                  <span>{{ torrent.completed_downloads }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Last checked:</span>
                  <span>{{ torrent.detail.lastchecked }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Date uploaded:</span>
                  <span>{{ torrent.detail.dateuploaded }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Seeders:</span>
                  <span class="text-green-400">{{ torrent.seeders }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Leechers:</span>
                  <span class="text-red-400">{{ torrent.leechers }}</span>
                </div>
              </div>
            </div>

            <!-- Download Buttons -->
            <div class="p-4 space-y-2">
              <a :href="`${torrent.detail.magnet_link}`"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded flex items-center justify-center space-x-2 font-semibold">
                <span>🧲</span>
                <span>MAGNET DOWNLOAD</span>
              </a>
              <button @click="downloadTorrent"
                class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded flex items-center justify-center space-x-2 font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                <span>TORRENT DOWNLOAD</span>
              </button>
              <transition name="slide">
                <div v-if="showDropdown" class="dropdown">
                  <a :href="`http://itorrents.org/torrent/${torrent.detail.infohash}.torrent`" target="_blank">ITORRENTS
                    MIRROR</a>
                  <a :href="`http://torrage.info/torrent.php?h=${torrent.detail.infohash}`" target="_blank">TRRAGE
                    MIRROR</a>
                  <a :href="`http://btcache.me/torrent/${torrent.detail.infohash}`" target="_blank">BTCACHE MIRROR</a>
                  <a :href="`${torrent.detail.magnet_link}`">NONE WORKING? USERMAGNET</a>
                </div>

              </transition>
              <button @click="playStream"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded flex items-center justify-center space-x-2 font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10c0-.552.448-1 1-1h4c.552 0 1 .448 1 1M9 10v4a1 1 0 001 1h4a1 1 0 001-1v-4m-6 0a1 1 0 011-1h4a1 1 0 011 1m-6 0v.01M15 10v.01">
                  </path>
                </svg>
                <span>PLAY NOW (STREAM)</span>
              </button>
            </div>
          </div>

          <!-- Hash -->
          <div class="text-center text-xs text-black mb-4">
            <span class="font-semibold">INFO HASH:</span> {{ torrent.detail.infohash }}
          </div>

          <!-- Tabs -->
          <div class="bg-gray-800 rounded">
            <div class="flex border-b border-gray-700">
              <button v-for="tab in tabs" :key="tab" @click="activeTab = tab" :class="[
                'px-4 py-2 text-sm font-medium',
                activeTab === tab
                  ? 'bg-gray-700 text-white'
                  : 'text-gray-400 hover:text-white'
              ]">
                {{ tab }}
              </button>
            </div>
            <div class="p-4">
              <div v-if="activeTab === 'DESCRIPTION'">
                <!-- Movie Description with HTML rendering -->
                <div v-if="torrent?.detail?.description" v-html="torrent.detail.description"
                  class="mt-4 text-gray-300 leading-relaxed"></div>
              </div>
              <div v-else-if="activeTab === 'FILES'">
                <div v-if="torrent?.detail?.files" v-html="torrent.detail.files"
                  class="mt-4 text-gray-300 leading-relaxed"></div>
              </div>
            
              <div v-else-if="activeTab === 'COMMENTS'">
                <div v-if="torrent?.detail?.comments" v-html="torrent.detail.comments"
                  class="mt-4 text-gray-300 leading-relaxed"></div>
              </div>

              <div v-else-if="activeTab === 'TRACKER LIST'">
                <div v-if="torrent?.detail?.trackerlist" v-html="torrent.detail.trackerlist"
                  class="mt-4 text-gray-300 leading-relaxed"></div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </AppLayout>
</template>
<script setup>
import { ref, reactive, onMounted } from 'vue'
import AppLayout from './../layouts/AppLayout.vue'
import torrentService from '@/api/torrentService.js'
import { usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const searchQuery = ref('')
const activeTab = ref('DESCRIPTION')
const showDropdown = ref(false)
const tabs = ref(['DESCRIPTION', 'FILES', 'COMMENTS 1', 'TRACKER LIST']);

const torrent = ref(null) // Will hold the API response
// Methods
const handleSearch = () => {
  console.log('Searching for:', searchQuery.value)
  // Implement search functionality
}

const downloadMagnet = () => {
  console.log('Downloading magnet link')
  // Implement magnet download
}

const downloadTorrent = () => {
  showDropdown.value = !showDropdown.value;
}

const playStream = () => {
  console.log('Starting stream')
  // Implement streaming functionality
}

// Fetch data from API
const fetchTorrentDetails = async (id, slug) => {
  try {
    const response = await torrentService.get(`/torrent/${id}/${slug}`);
    torrent.value = response.data // Assign to ref
  } catch (error) {
    console.error('Error fetching torrent details:', error);
  }
};

// Fetch data when mounted
onMounted(() => {
  const page = usePage();
  const torrentId = page.props.torrent_id; // 
  const torrentSlug = page.props.torrent_slug; // 
  fetchTorrentDetails(torrentId, torrentSlug);
});



</script>
<style scoped>
.btn {
  display: block;
  width: 250px;
  padding: 10px;
  color: white;
  font-weight: bold;
  text-align: left;
  border: none;
  cursor: pointer;
  margin-bottom: 5px;
}

.btn .icon {
  margin-right: 8px;
}

.torrent {
  background-color: #a63b20;
}

/* Dropdown styles */
.dropdown {
  background: #8b1818;
  display: flex;
  flex-direction: column;
  padding: 5px;
  margin-bottom: 5px;
}

.dropdown a {
  color: white;
  text-decoration: none;
  padding: 5px;
  font-weight: bold;
  padding-top: 6px;

}

.dropdown a:hover {
  background: #313030;
}

/* Slide transition */
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
  overflow: hidden;
}

.slide-enter-from,
.slide-leave-to {
  max-height: 0;
  opacity: 0;
}

.slide-enter-to,
.slide-leave-from {
  max-height: 200px;
  /* adjust for more links */
  opacity: 1;
}
</style>