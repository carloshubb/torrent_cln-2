<script setup>
import AppLayout from './../layouts/AppLayout.vue'
import TorrentTable from '../Compenents/TorrentTable.vue'
import TorrentHead from '../Compenents/TorrentHead.vue'
import { reactive, onMounted } from 'vue'
import torrentService from '@/api/torrentService.js'

// get props data
const props = defineProps({
  page: String,
  params: String,
});
// some data in parent
const dashboard_data = reactive([])
const dashboard_images = reactive([])
// Fetch function to get torrent data and update dashboard_data
async function fetchMostPopularTorrents() {
  try {
    const response = await torrentService.get('/torrents/type?type=mostpopular');
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    dashboard_data.push({
      title: 'MOST POPULAR THIS WEEK',
      data: response.data,
      page: 'dashboard'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Popular Movie Torrents  data and update dashboard_data
async function fetchPopularMovieTorrents() {
  try {
    const response = await torrentService.get('/torrents/type?type=popularmovie');
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    dashboard_data.push({
      title: 'Popular Movie Torrents THIS WEEK',
      data: response.data,
      page: 'dashboard'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Popular Foreign Movie  Torrents  data and update dashboard_data
async function fetchPopularForeignMovieTorrents() {
  try {
    const response = await torrentService.get('/torrents/type?type=popularforeignmovie');
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    dashboard_data.push({
      title: 'Popular Foreign Movie Torrents THIS WEEK',
      data: response.data,
      page: 'dashboard'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Popular TV  Torrents  data and update dashboard_data
async function fetchPopularTVTorrents() {
  try {
    const response = await torrentService.get('/torrents/type?type=populartv');
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    dashboard_data.push({
      title: 'Popular TV Torrents THIS WEEK',
      data: response.data,
      page: 'dashboard'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Popular Music  Torrents  data and update dashboard_data
async function fetchPopularMusicTorrents() {
  try {
    const response = await torrentService.get('/torrents/type?type=popularmusic');
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    dashboard_data.push({
      title: 'Popular Music Torrents THIS WEEK',
      data: response.data,
      page: 'dashboard'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Popular Application  Torrents  data and update dashboard_data
async function fetchPopularApplicationTorrents() {
  try {
    const response = await torrentService.get('/torrents/type?type=popularapplication');
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    dashboard_data.push({
      title: 'Popular Application Torrents THIS WEEK',
      data: response.data,
      page: 'dashboard'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Popular Application  Torrents  data and update dashboard_data
async function fetchPopularGameTorrents() {
  try {
    const response = await torrentService.get('/torrents/type?type=populargame');
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    dashboard_data.push({
      title: 'Popular Game Torrents THIS WEEK',
      data: response.data,
      page: 'dashboard'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Popular Application  Torrents  data and update dashboard_data
async function fetchPopularOtherTorrents() {
  try {
    const response = await torrentService.get('/torrents/type?type=popularother');
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    dashboard_data.push({
      title: 'Popular Other Torrents THIS WEEK',
      data: response.data,
      page: 'dashboard'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}


// Fetch function to get Sub Category  Torrents  data and update dashboard_data
async function fetchSubCategoryTorrents(category, page) {

  try {
    const response = await torrentService.get(`/torrents/type?type=subcategory&sub_cat=${category}&page=${page}`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: '',
      data: response.data,
      page: 'sub'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}


// Fetch function to get Sub Category  Torrents  data and update dashboard_data
async function fetchCategoryTorrents(category, page) {
  try {
    const response = await torrentService.get(`/torrents/type?type=category&cat=${category}&page=${page}`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    const titles = {
      Anime: "Anime Torrents download list",
      Apps: "Apps Torrents download list",
      Documentaries: "Documentaries Torrents download list",
      Games: "Games Torrents download list",
      Movies: "Movies Torrents download list",
      Music: "Music Torrents download list",
      Other: "Other Torrents download list",
      TV: "TV Torrents download list",
      XXX: "XXX Torrents download list"
    };

    const title = titles[category] || "Torrents download list";   
       
    dashboard_data.push({
      title: title,
      data: response.data,
      page: 'cat'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Trending Torrents  data and update dashboard_data
async function fetchTrendingTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING TORRENTS LAST 24 HOURS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100Torrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 TORRENTS',
      data: response.data,
      page: 'top'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch Home Page Image
async function fetchHomePageImage() {
  try {
    const response = await torrentService.get(`/torrents/type?type=homeimage`);
    dashboard_images.value = response.data; // update reactive value
  } catch (error) {
    console.error('Failed to fetch torrents:', error);
  }
}

// Fetch Search Torrent Data
async function fetchSearchTorrentData(search, page) {
  try {
    const response = await torrentService.get(`/torrents/type?type=search&search=${search}&page=${page}`);
    dashboard_data.push({
      title: `Searching  for: ${search}`,
      data: response.data,
      page: 'search'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error);
  }
}
// Run fetch on component mount
onMounted(() => {
  console.log('Page:', props.page);
  fetchHomePageImage()
  if (props.page === 'dashboard') {

    dashboard_data.splice(0)
    fetchMostPopularTorrents()
    fetchPopularMovieTorrents()
    fetchPopularForeignMovieTorrents()
    fetchPopularTVTorrents()
    fetchPopularMusicTorrents()
    fetchPopularApplicationTorrents()
    fetchPopularGameTorrents()
    fetchPopularOtherTorrents()

  }
  else if (props.page === 'sub') {
    dashboard_data.splice(0)
    const sub_category = props.params.split("@")[0] ? props.params.split("@")[0] : null;
    const page = props.params.split("@")[1] ? props.params.split("@")[1] : null;
    if (sub_category != null) fetchSubCategoryTorrents(sub_category, page)
  }
  else if (props.page === 'cat') {
    dashboard_data.splice(0)
    const category = props.params.split("@")[0] ? props.params.split("@")[0] : null;
    const page = props.params.split("@")[1] ? props.params.split("@")[1] : null;
    if (category != null) fetchCategoryTorrents(category, page)
  }

  else if (props.page === 'trending') {
    dashboard_data.splice(0)
    fetchTrendingTorrents()
  }
  else if (props.page === 'top') {
    dashboard_data.splice(0)
    fetchTop100Torrents()
  }
  else if (props.page === 'search') {
    dashboard_data.splice(0)
    const search = props.params.split("@")[0] ? props.params.split("@")[0] : null;
    const page = props.params.split("@")[1] ? props.params.split("@")[1] : null;
    fetchSearchTorrentData(search, page)
  }


})
</script>
<template>
  
  <AppLayout>
    <TorrentHead :dashboard_images="dashboard_images" :page="props.page" />
    <TorrentTable v-for="(row, index) in dashboard_data" :key="index" :torrents="row.data" :page="row.page"
      :head_title="row.title" />
  </AppLayout>

</template>
