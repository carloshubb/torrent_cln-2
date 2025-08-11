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
