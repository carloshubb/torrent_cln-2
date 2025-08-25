<template>
  <div class="md:col-span-3 px-2 md:px-0 mt-5">
    <!-- Browse Torrents -->
    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-xl">
      <div class="bg-gradient-to-r from-orange-500 to-gray-500 px-4 py-3">
        <h3 class="text-white font-bold">BROWSE TORRENTS</h3>
      </div>
      <ul class="list-box">
        <li v-for="(category, index) in browseCategories" :key="index"
          class="flex text-gray-300 hover:text-orange-400 cursor-pointer transition-colors px-4 py-1 border-b-1 border-gray-600"
          >
          <a :href="category.slug">
            <i :class=category.icon></i>
            {{ category.title }}
          </a>
        </li>
      </ul>
    </div>

    
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

import { ref, reactive, onMounted } from 'vue'

export default {
  name: 'TorrentSite',
  setup() {
    const browseCategories = [
      { title: 'Trending Torrents', icon: 'flaticon-trending', slug: '/trending' },
      { title: 'Movie library', icon: 'flaticon-movie-library', slug: '/movielibrary/1' },
      { title: 'Top 100 Torrents', icon: 'flaticon-top', slug: '/top-100' },
      { title: 'Anime', icon: 'flaticon-ninja-portrait', slug: '/cat/Anime/1' },
      { title: 'Applications', icon: 'flaticon-apps', slug: '/cat/Apps/1' },
      { title: 'Documentaries', icon: 'flaticon-documentary', slug: '/cat/Documentaries/1' },
      { title: 'Games', icon: 'flaticon-games', slug: '/cat/Games/1' },
      { title: 'Movies', icon: 'flaticon-movies', slug: '/cat/Movies/1' },
      { title: 'Music', icon: 'flaticon-music', slug: '/cat/Music/1' },
      { title: 'Other', icon: 'flaticon-other', slug: '/cat/Other/1' },
      { title: 'Television', icon: 'flaticon-tv', slug: '/cat/TV/1' },
      { title: 'XXX', icon: 'flaticon-xxx', slug: '/cat/XXX/1' },

    ]
    const externalLinks = [
      '1331x Status',
      '1331x Chat',
      'Torrent9',
      'uTrix',
      'Njalla',
      'PRQ',
      'Limetorrents',
      'TorrentFunk',
      'ThePornDude',
      'Torlock'
    ]




    const browseCategory = (category) => {
      console.log('Browsing category:', category)
      if (category.slug == 'trending' || category.slug == 'top-100') {
        window.location.href = `/${category.slug}`;
      }
      else if (category.slug == 'movielibrary') {
        window.location.href = `/${category.slug}/1/`;
      }
      else {
        window.location.href = `/cat/${category.slug}/1/`;
      }
      // Implement category browsing logic
      // Navigate to category page or filter torrents
    }

    const openLink = (link) => {
      console.log('Opening link:', link)
      if (link == '1331x Status') {
        window.location.href = `https://1337x-status.org/`;
      }
      else if (link == '1331x Chat') {
        window.location.href = `https://1337x.to/login`;
      }
      else if (link == 'Torrent9') {
        window.location.href = `https://torrentz9.org/`;
      }
      else if (link == 'uTrix') {
        window.location.href = `https://uflix.to/`;
      }
      else if (link == 'Njalla') {
        window.location.href = `https://njal.la/`;
      }
      else if (link == 'PRQ') {
        window.location.href = `https://prq.se/`;
      }
      else if (link == 'Limetorrents') {
        window.location.href = `https://www.limetorrents.lol/`;
      }
      else if (link == 'TorrentFunk') {
        window.location.href = `https://www.torrentfunk.com/`;
      }
      else if (link == 'ThePornDude') {
        window.location.href = `https://theporndude.com/`;
      }
      else if (link == 'Torlock') {
        window.location.href = `https://www.torlock.com/`;
      }
      // Implement external link logic
      // Open in new tab or navigate
    }

    onMounted(() => {
      console.log('TorrentSite component mounted')
      // Initialize component, fetch data, etc.
    })

    return {
      browseCategories,
      externalLinks,
      browseCategory,
      openLink
    }
  }
}
</script>

<style scoped>
/* Add any component-specific styles here if needed */
.bg-gray-750 {
  background-color: rgba(168, 174, 185, 0.5);
}

.list-box li {
    color: #dadada;
    display: block;
    font-size: 14px;
    line-height: 38px;
    padding: 0 12px 0 49px;
    position: relative;
}
.list-box li i {
  height: 30px;
  left: 12px;
  margin-right: 7px;
  position: absolute;
  top: 0;
  width: 30px;
  color: #56add9;
  font-size: 23px;
}
.list-box i.flaticon-trending, .list-box i.flaticon-movie-library, .list-box i.flaticon-tv-library {
    color: #89ad19;
}
</style>