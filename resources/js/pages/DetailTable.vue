<script setup>
import AppLayout from './../layouts/AppLayout.vue'
import TorrentTable from '../Compenents/TorrentTable.vue'
import TorrentHead from '../Compenents/TorrentHead.vue'
import TorrentDetailHead from '../Compenents/TorrentDetailHead.vue'
import { reactive } from 'vue'
// some data in parent

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


const detail_data = []; 
detail_data.push({data:torrentInfo, info:movieInfo})

</script>
<template>
  <AppLayout> 
   <TorrentDetailHead 
     v-for="(row, index) in detail_data"
        :key="index"
        :torrents="row.data"
        :info="row.info"/>
  </AppLayout>
   
</template>
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
  max-height: 200px; /* adjust for more links */
  opacity: 1;
}
</style>