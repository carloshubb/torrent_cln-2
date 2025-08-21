<script setup>
import AppLayout from './../layouts/AppLayout.vue'
import TorrentTable from '../Compenents/TorrentTable.vue'
import TorrentHead from '../Compenents/TorrentHead.vue'
import { reactive, onMounted, ref } from 'vue'
import torrentService from '@/api/torrentService.js'
import { Head } from '@inertiajs/vue3'
import { useHead } from "@vueuse/head";

useHead({
  title: "Welcome to 1331x.com",
  meta: [
    {
      name: "description",
      content: "This is the SEO meta description for my Vue 3 page."
    }
  ]
});

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
      icon: 'flaticon-top',
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
    // //For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data
    dashboard_data.push({
      icon: 'flaticon-movies',
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
      icon: 'flaticon-movies',
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
      icon: 'flaticon-tv',
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
      icon: 'flaticon-music',
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
      icon: 'flaticon-apps',
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
      icon: 'flaticon-games',
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
      icon: 'flaticon-other',
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
    
    
    const title = response.data ? response.data.data.data[0].subcategory.name+ " Torrents download list" : 'Torrents download list';
    dashboard_data.push({
      title: title,
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
//fetchTrendingWeekTorrents
async function fetchTrendingWeekTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-week`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING TORRENTS LAST 7 DAYS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}
//fetchTrendingMoviesWeekTorrents
async function fetchTrendingMoviessDayTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-d-movies`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING MOVIES TORRENTS LAST 24 HOURS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

//fetchTrendingMoviesWeekTorrents
async function fetchTrendingTvDayTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-d-tv`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING TV TORRENTS LAST 24 HOURS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}
//fetchTrendingGamesDayTorrents
async function fetchTrendingGamesDayTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-d-games`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING GAMES TORRENTS LAST 24 HOURS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

//fetchTrendingGamesDayTorrents
async function fetchTrendingAppsDayTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-d-apps`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING APPLICATIONS TORRENTS LAST 24 HOURS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

//fetchTrendingGamesDayTorrents
async function fetchTrendingMusicDayTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-d-music`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING MUSIC TORRENTS LAST 24 HOURS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}
//fetchTrendingDocDayTorrents
async function fetchTrendingDocDayTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-d-doc`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING MOCMENTARIES TORRENTS LAST 24 HOURS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}
//fetchTrendingAnimeDayTorrents
async function fetchTrendingAnimeDayTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-d-anime`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING ANIME TORRENTS LAST 24 HOURS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

//fetchTrendingAnimeDayTorrents
async function fetchTrendingOtherDayTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-d-other`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING ANIME TORRENTS LAST 24 HOURS',
      data: response.data,
      page: 'trending'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

//fetchTrendingXxxDayTorrents
async function fetchTrendingXxxDayTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=trending-d-xxx`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TRENDING XXX TORRENTS LAST 24 HOURS',
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

// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100MovieTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top-100-movies`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 MOVIES',
      data: response.data,
      page: 'top'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}
// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100TvTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top-100-tv`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 TVs',
      data: response.data,
      page: 'top'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100GamesTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top-100-games`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 Games',
      data: response.data,
      page: 'top'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100AppsTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top-100-apps`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 Apps',
      data: response.data,
      page: 'top'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100MusicTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top-100-music`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 Musics',
      data: response.data,
      page: 'top'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100DocTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top-100-doc`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 Documentaries',
      data: response.data,
      page: 'top'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100AnimeTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top-100-anime`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 Animes',
      data: response.data,
      page: 'top'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100OtherTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top-100-other`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 Others',
      data: response.data,
      page: 'top'
    })
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}

// Fetch function to get Top 100 Torrents  data and update dashboard_data
async function fetchTop100XxxTorrents() {
  try {
    const response = await torrentService.get(`/torrents/type?type=top-100-xxx`);
    // For demo, assuming all torrents in one group with title "All Torrents"
    //dashboard_data.splice(0) // clear previous data type=subcategory&sub_cat=someValue
    dashboard_data.push({
      title: 'TOP 100 Xxx',
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
    dashboard_images.push({
      title:'images',
      data : response.data,
    })
    
    
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
  else if (props.page === 'trending-week') {
    dashboard_data.splice(0)
    fetchTrendingWeekTorrents()
  }
  else if (props.page === 'trending-d-movies') {
    dashboard_data.splice(0)
    fetchTrendingMoviessDayTorrents()
  }
  else if (props.page === 'trending-d-tv') {
    dashboard_data.splice(0)
    fetchTrendingTvDayTorrents()
  }
  else if (props.page === 'trending-d-games') {
    dashboard_data.splice(0)
    fetchTrendingGamesDayTorrents()
  }

  else if (props.page === 'trending-d-apps') {
    dashboard_data.splice(0)
    fetchTrendingAppsDayTorrents()
  }
  else if (props.page === 'trending-d-music') {
    dashboard_data.splice(0)
    fetchTrendingMusicDayTorrents()
  }
  else if (props.page === 'trending-d-doc') {
    dashboard_data.splice(0)
    fetchTrendingDocDayTorrents()
  }
  else if (props.page === 'trending-d-anime') {
    dashboard_data.splice(0)
    fetchTrendingAnimeDayTorrents()
  }
  else if (props.page === 'trending-d-other') {
    dashboard_data.splice(0)
    fetchTrendingOtherDayTorrents()
  }
  else if (props.page === 'trending-d-xxx') {
    dashboard_data.splice(0)
    fetchTrendingXxxDayTorrents()
  }
  else if (props.page === 'top') {
    dashboard_data.splice(0)
    fetchTop100Torrents()
  }
  else if (props.page === 'top-100-movies') {
    dashboard_data.splice(0)
    fetchTop100MovieTorrents()
  }
  else if (props.page === 'top-100-television') {
    dashboard_data.splice(0)
    fetchTop100TvTorrents()
  }
  else if (props.page === 'top-100-games') {
    dashboard_data.splice(0)
    fetchTop100GamesTorrents()
  }
  else if (props.page === 'top-100-applications') {
    dashboard_data.splice(0)
    fetchTop100AppsTorrents()
  }
  else if (props.page === 'top-100-music') {
    dashboard_data.splice(0)
    fetchTop100MusicTorrents()
  }
  else if (props.page === 'top-100-documentaries') {
    dashboard_data.splice(0)
    fetchTop100DocTorrents()
  }
  else if (props.page === 'top-100-anime') {
    dashboard_data.splice(0)
    fetchTop100AnimeTorrents()
  }
  else if (props.page === 'top-100-other') {
    dashboard_data.splice(0)
    fetchTop100OtherTorrents()
  }
  else if (props.page === 'top-100-xxx') {
    dashboard_data.splice(0)
    fetchTop100XxxTorrents()
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
  <Head/>
  <h1> </h1>
  <AppLayout>
    <TorrentHead v-if="dashboard_images.length > 0" :images="dashboard_images" :page="props.page" />
    <TorrentTable v-for="(row, index) in dashboard_data" :key="index" :torrents="row.data" :page="row.page"   :icon="row.icon"
      :head_title="row.title" />
  </AppLayout>
</template>
