<template>
  <div class="min-h-screen bg-gray-900 text-white font-sans">
    <!-- Header -->
    <div class="bg-black border-b border-orange-600">
      <div class="max-w-7xl mx-auto px-4 py-2 flex justify-between ">
        <div class="flex items-center space-x-6">
          <div class="text-2xl font-bold text-orange-500">1337X</div>
          <nav class="hidden md:flex space-x-1">
            <a href="#" class="bg-gray-700 px-4 py-2 text-sm hover:bg-gray-600">HOME</a>
            <a href="#" class="bg-orange-400 px-4 py-2 text-sm hover:bg-orange-600">UPLOAD</a>
            <a href="#" class="bg-orange-400 px-4 py-2 text-sm hover:bg-orange-600">RULES</a>
            <a href="#" class="bg-orange-400 px-4 py-2 text-sm hover:bg-orange-600">CONTACT</a>
            <a href="#" class="bg-orange-400 px-4 py-2 text-sm hover:bg-orange-600">ABOUT US</a>
          </nav>
        </div>
        <div class="flex items-center space-x-2">
          <div class="relative">
            <input 
              type="text" 
              placeholder="Search for torrents"
              v-model="searchQuery"
              class="bg-gray-800 text-white px-4 py-1 pr-10 rounded border border-gray-600 focus:outline-none focus:border-orange-500"
            />
            <button @click="handleSearch" class="absolute right-0 top-0 bg-orange-600 px-3 py-1 rounded-r hover:bg-orange-700">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </button>
          </div>
          <div class="text-xs space-x-2">
            <a href="#" class="text-orange-500 hover:underline">REGISTER</a>
            <a href="#" class="text-orange-500 hover:underline">LOGIN</a>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-4">
      <div class="flex gap-6">
        <!-- Main Content -->
        <div class="flex-1">
          <!-- Title -->
          <div class="bg-gray-700 px-4 py-2 mb-4 rounded">
            <h1 class="text-lg font-semibold">{{ torrentInfo.title }}</h1>
          </div>

          <!-- Torrent Info -->
          <div class="bg-gray-800 rounded mb-4">
            <div class="grid grid-cols-2 gap-4 p-4 text-sm">
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-gray-400">Category:</span>
                  <span>{{ torrentInfo.category }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Type:</span>
                  <span>{{ torrentInfo.type }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Language:</span>
                  <span>{{ torrentInfo.language }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Total Size:</span>
                  <span>{{ torrentInfo.size }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Uploaded By:</span>
                  <span class="text-green-400">{{ torrentInfo.uploader }}</span>
                </div>
              </div>
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-gray-400">Downloads:</span>
                  <span>{{ torrentInfo.downloads }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Last checked:</span>
                  <span>{{ torrentInfo.lastChecked }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Date uploaded:</span>
                  <span>{{ torrentInfo.dateUploaded }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Seeders:</span>
                  <span class="text-green-400">{{ torrentInfo.seeders }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Leechers:</span>
                  <span class="text-red-400">{{ torrentInfo.leechers }}</span>
                </div>
              </div>
            </div>

            <!-- Download Buttons -->
            <div class="p-4 space-y-2">
              <button @click="downloadMagnet" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded flex items-center justify-center space-x-2 font-semibold">
                <span>🧲</span>
                <span>MAGNET DOWNLOAD</span>
              </button>
              <button @click="downloadTorrent" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded flex items-center justify-center space-x-2 font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                <span>TORRENT DOWNLOAD</span>
              </button>
              <button @click="playStream" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded flex items-center justify-center space-x-2 font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10c0-.552.448-1 1-1h4c.552 0 1 .448 1 1M9 10v4a1 1 0 001 1h4a1 1 0 001-1v-4m-6 0a1 1 0 011-1h4a1 1 0 011 1m-6 0v.01M15 10v.01"></path>
                </svg>
                <span>PLAY NOW (STREAM)</span>
              </button>
            </div>
          </div>

          <!-- Movie Info Card -->
          <div class="bg-orange-600 p-4 rounded flex space-x-4 mb-4">
            <img 
              :src="movieInfo.poster" 
              :alt="movieInfo.title"
              class="w-24 h-36 object-cover rounded"
            />
            <div class="flex-1">
              <h2 class="text-xl font-bold mb-2">{{ movieInfo.title }}</h2>
              <p class="text-xs mb-2 uppercase tracking-wide">{{ movieInfo.genres.join(' • ') }}</p>
              <p class="text-sm leading-relaxed">{{ movieInfo.description }}</p>
              <div class="flex items-center mt-3">
                <div v-for="star in 5" :key="star" class="w-4 h-4 mr-1">
                  <svg 
                    :class="star <= movieInfo.rating ? 'fill-orange-400 text-orange-400' : 'text-gray-400'"
                    fill="currentColor" 
                    viewBox="0 0 20 20"
                  >
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Hash -->
          <div class="text-center text-xs text-gray-400 mb-4">
            <span class="font-semibold">INFO HASH:</span> {{ torrentInfo.hash }}
          </div>

          <!-- Tabs -->
          <div class="bg-gray-800 rounded">
            <div class="flex border-b border-gray-700">
              <button
                v-for="tab in tabs"
                :key="tab"
                @click="activeTab = tab"
                :class="[
                  'px-4 py-2 text-sm font-medium',
                  activeTab === tab 
                    ? 'bg-gray-700 text-white' 
                    : 'text-gray-400 hover:text-white'
                ]"
              >
                {{ tab }}
              </button>
            </div>
            <div class="p-4">
              <div v-if="activeTab === 'DESCRIPTION'">
                <img 
                  src="https://via.placeholder.com/600x300/374151/ffffff?text=Movie+Scene"
                  alt="Movie scene"
                  class="w-full rounded"
                />
              </div>
              <div v-else-if="activeTab === 'FILES'">
                <div class="text-sm">
                  <p>Files information will be displayed here...</p>
                </div>
              </div>
              <div v-else-if="activeTab === 'COMMENTS 1'">
                <div class="text-sm">
                  <p>Comments section...</p>
                </div>
              </div>
              <div v-else-if="activeTab === 'TRACKER LIST'">
                <div class="text-sm">
                  <p>Tracker list will be shown here...</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="w-64 space-y-4">
          <!-- Browse Torrents -->
          <div class="bg-orange-600 rounded">
            <div class="bg-orange-700 px-3 py-2 text-sm font-semibold">
              BROWSE TORRENTS
            </div>
            <div class="p-3 space-y-2 text-sm">
              <a 
                v-for="category in browseCategories" 
                :key="category.name"
                href="#" 
                class="flex items-center space-x-2 hover:text-orange-300"
              >
                <span class="text-orange-400">{{ category.icon }}</span>
                <span>{{ category.name }}</span>
              </a>
            </div>
          </div>

          <!-- 1337X Links -->
          <div class="bg-orange-600 rounded">
            <div class="bg-orange-700 px-3 py-2 text-sm font-semibold">
              1337X LINKS
            </div>
            <div class="p-3 space-y-1 text-xs">
              <a 
                v-for="link in externalLinks" 
                :key="link"
                href="#" 
                class="block hover:text-orange-300"
              >
                ▶ {{ link }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from 'vue'

export default {
  name: 'TorrentSitePage',
  setup() {
    const searchQuery = ref('')
    const activeTab = ref('DESCRIPTION')
    
    const torrentInfo = reactive({
      title: 'Jurassic World Rebirth 2025 1080p WEBRip DOPS Lx265 NeoNoir',
      category: 'Movies',
      type: 'HEVC/x265',
      language: 'English',
      size: '2.0 GB',
      uploader: 'NeoNoir',
      downloads: '82751',
      lastChecked: '49 minutes ago',
      dateUploaded: '4 days ago',
      seeders: '5452',
      leechers: '2620',
      hash: '911CCD0C4C8A23284A920B61528888D293AC055B'
    })

    const movieInfo = reactive({
      title: 'JURASSIC WORLD REBIRTH',
      genres: ['SCIENCE FICTION', 'ADVENTURE', 'ACTION'],
      description: "Five years after the events of Jurassic World Dominion, covert operations expert Zora Bennett is contracted to lead a skilled team on a top-secret mission to secure genetic material from the world's three most massive dinosaurs. When Zora's operation intersects with a civilian family whose boating expedition was capsized, they all find themselves stranded on an island where they come face-to-face with a sinister, shocking discovery that's been hidden from the world for decades.",
      rating: 3,
      poster: 'https://via.placeholder.com/120x180/374151/ffffff?text=Movie+Poster'
    })

    const tabs = ['DESCRIPTION', 'FILES', 'COMMENTS 1', 'TRACKER LIST']

    const browseCategories = [
      { name: 'Trending Torrents', icon: '📈' },
      { name: 'Movie library', icon: '📚' },
      { name: 'Top 100 Torrents', icon: '⭐' },
      { name: 'Anime', icon: '📺' },
      { name: 'Applications', icon: '💾' },
      { name: 'Documentaries', icon: '🎬' },
      { name: 'Games', icon: '🎮' },
      { name: 'Movies', icon: '🎬' },
      { name: 'Music', icon: '🎵' },
      { name: 'Other', icon: '📄' },
      { name: 'Television', icon: '📺' },
      { name: 'XXX', icon: '🔞' }
    ]

    const externalLinks = [
      '1337x Status',
      '1337x Chat',
      'Torrentz9',
      'uFlix',
      'Ngilia',
      'PRQ',
      'Limetorrents',
      'TorrentFunk',
      'ThePornDude',
      'Torlock'
    ]

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
      console.log('Downloading torrent file')
      // Implement torrent download
    }

    const playStream = () => {
      console.log('Starting stream')
      // Implement streaming functionality
    }

    return {
      searchQuery,
      activeTab,
      torrentInfo,
      movieInfo,
      tabs,
      browseCategories,
      externalLinks,
      handleSearch,
      downloadMagnet,
      downloadTorrent,
      playStream
    }
  }
}
</script>

<style scoped>
/* Add any additional custom styles here if needed */
</style>