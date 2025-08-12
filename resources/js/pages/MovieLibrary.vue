<template>
  <AppLayout>
        <div class="pt-5 w-full bg-gray-300 text-white">
            <div class="container" >
            <!-- Filter Controls -->
            <div class="bg-gray-800 p-4 rounded-lg mb-6 flex items-center gap-4 flex-wrap">
                <!-- Genre Dropdown -->
                <div class="relative">
                <label class="block text-sm font-medium mb-1">Genre</label>
                <div class="relative">
                    <button 
                    @click="toggleDropdown('genre')" 
                    class="bg-gray-700 border border-gray-600 px-4 py-2 rounded w-40 text-left flex items-center justify-between hover:bg-gray-600 transition-colors"
                    >
                    <span>{{ selectedGenre }}</span>
                    <svg 
                        class="w-4 h-4 transition-transform" 
                        :class="{ 'rotate-180': dropdowns.genre }" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    </button>
                    <div 
                    v-if="dropdowns.genre" 
                    class="absolute top-full left-0 mt-1 w-40 bg-gray-700 border border-gray-600 rounded shadow-lg z-10"
                    >
                    <button 
                        v-for="genre in genres" 
                        :key="genre" 
                        @click="selectGenre(genre)"
                        class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition-colors first:rounded-t last:rounded-b"
                    >
                        {{ genre }}
                    </button>
                    </div>
                </div>
                </div>

                <!-- Year Dropdown -->
                <div class="relative">
                <label class="block text-sm font-medium mb-1">Year</label>
                <div class="relative">
                    <button 
                    @click="toggleDropdown('year')" 
                    class="bg-gray-700 border border-gray-600 px-4 py-2 rounded w-32 text-left flex items-center justify-between hover:bg-gray-600 transition-colors"
                    >
                    <span>{{ selectedYear }}</span>
                    <svg 
                        class="w-4 h-4 transition-transform" 
                        :class="{ 'rotate-180': dropdowns.year }" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    </button>
                    <div 
                    v-if="dropdowns.year" 
                    class="absolute top-full left-0 mt-1 w-32 bg-gray-700 border border-gray-600 rounded shadow-lg z-10"
                    >
                    <button 
                        v-for="year in years" 
                        :key="year" 
                        @click="selectYear(year)"
                        class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition-colors first:rounded-t last:rounded-b"
                    >
                        {{ year }}
                    </button>
                    </div>
                </div>
                </div>

                <!-- Language Dropdown -->
                <div class="relative">
                <label class="block text-sm font-medium mb-1">Language</label>
                <div class="relative">
                    <button 
                    @click="toggleDropdown('language')" 
                    class="bg-gray-700 border border-gray-600 px-4 py-2 rounded w-36 text-left flex items-center justify-between hover:bg-gray-600 transition-colors"
                    >
                    <span>{{ selectedLanguage }}</span>
                    <svg 
                        class="w-4 h-4 transition-transform" 
                        :class="{ 'rotate-180': dropdowns.language }" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    </button>
                    <div 
                    v-if="dropdowns.language" 
                    class="absolute top-full left-0 mt-1 w-36 bg-gray-700 border border-gray-600 rounded shadow-lg z-10"
                    >
                    <button 
                        v-for="language in languages" 
                        :key="language" 
                        @click="selectLanguage(language)"
                        class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition-colors first:rounded-t last:rounded-b"
                    >
                        {{ language }}
                    </button>
                    </div>
                </div>
                </div>

                <!-- Sort By Dropdown -->
                <div class="relative">
                <label class="block text-sm font-medium mb-1">Sort By</label>
                <div class="relative">
                    <button 
                    @click="toggleDropdown('sortBy')" 
                    class="bg-gray-700 border border-gray-600 px-4 py-2 rounded w-40 text-left flex items-center justify-between hover:bg-gray-600 transition-colors"
                    >
                    <span>{{ selectedSortBy }}</span>
                    <svg 
                        class="w-4 h-4 transition-transform" 
                        :class="{ 'rotate-180': dropdowns.sortBy }" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    </button>
                    <div 
                    v-if="dropdowns.sortBy" 
                    class="absolute top-full left-0 mt-1 w-40 bg-gray-700 border border-gray-600 rounded shadow-lg z-10"
                    >
                    <button 
                        v-for="sortOption in sortOptions" 
                        :key="sortOption" 
                        @click="selectSortBy(sortOption)"
                        class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition-colors first:rounded-t last:rounded-b"
                    >
                        {{ sortOption }}
                    </button>
                    </div>
                </div>
                </div>

                <!-- Sort Order Dropdown -->
                <div class="relative">
                <label class="block text-sm font-medium mb-1">Sort</label>
                <div class="relative">
                    <button 
                    @click="toggleDropdown('sortOrder')" 
                    class="bg-gray-700 border border-gray-600 px-4 py-2 rounded w-32 text-left flex items-center justify-between hover:bg-gray-600 transition-colors"
                    >
                    <span>{{ selectedSortOrder }}</span>
                    <svg 
                        class="w-4 h-4 transition-transform" 
                        :class="{ 'rotate-180': dropdowns.sortOrder }" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    </button>
                    <div 
                    v-if="dropdowns.sortOrder" 
                    class="absolute top-full left-0 mt-1 w-32 bg-gray-700 border border-gray-600 rounded shadow-lg z-10"
                    >
                    <button 
                        v-for="order in sortOrders" 
                        :key="order" 
                        @click="selectSortOrder(order)"
                        class="block w-full text-left px-4 py-2 hover:bg-gray-600 transition-colors first:rounded-t last:rounded-b"
                        :class="{ 'text-red-400': order === 'Descending' }"
                    >
                        {{ order }}
                    </button>
                    </div>
                </div>
                </div>

                <!-- Sort Button -->
                <div class="flex items-end">
                <button 
                    @click="sortMovies" 
                    class="bg-gray-800 hover:bg-gray-700 border border-gray-600 px-6 py-2 rounded font-medium transition-colors"
                >
                    Sort
                </button>
                </div>
            </div>

            <!-- Movies Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <div 
                v-for="movie in filteredAndSortedMovies" 
                :key="movie.id" 
                class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow"
                >
                <div class="aspect-[2/3] bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center relative">
                    <!-- Movie Poster Placeholder -->
                    <div 
                    class="w-full h-full bg-cover bg-center" 
                    :style="{ backgroundImage: `url(${movie.poster})` }"
                    >
                    <div class="w-full h-full bg-black bg-opacity-40 flex items-center justify-center">
                        <span class="text-lg font-semibold text-center px-2">{{ movie.title }}</span>
                    </div>
                    </div>
                </div>
                <!-- Star Rating -->
                <div class="p-2 flex justify-center">
                    <div class="flex">
                    <svg 
                        v-for="star in 5" 
                        :key="star" 
                        :class="star <= movie.rating ? 'text-yellow-400' : 'text-gray-500'"
                        class="w-4 h-4" 
                        fill="currentColor" 
                        viewBox="0 0 20 20"
                    >
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AppLayout from './../layouts/AppLayout.vue'

// Reactive data
const dropdowns = ref({
  genre: false,
  year: false,
  language: false,
  sortBy: false,
  sortOrder: false
})

const selectedGenre = ref('All')
const selectedYear = ref('All')
const selectedLanguage = ref('All')
const selectedSortBy = ref('Movie Score')
const selectedSortOrder = ref('Descending')

// Options
const genres = ref(['All', 'Action', 'Crime', 'Drama', 'Comedy', 'Thriller', 'Horror', 'Romance', 'Sci-Fi', 'Adventure'])
const years = ref(['All','2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015'])
const languages = ref(['All', 'English', 'Spanish', 'French', 'German', 'Italian', 'Japanese', 'Korean', 'Chinese'])
const sortOptions = ref(['Movie Score', 'Release Date', 'Title', 'Rating', 'Year'])
const sortOrders = ref(['Descending', 'Ascending'])

// Movies data
const movies = ref([
  { id: 1, title: 'The Dark Knight', genre: 'Action', year: 2008, language: 'English', score: 9.0, rating: 5, poster: 'https://via.placeholder.com/200x300/4a5568/ffffff?text=Movie+1' },
  { id: 2, title: 'Pulp Fiction', genre: 'Crime', year: 1994, language: 'English', score: 8.9, rating: 5, poster: 'https://via.placeholder.com/200x300/ed8936/ffffff?text=Movie+2' },
  { id: 3, title: 'The Godfather', genre: 'Crime', year: 1972, language: 'English', score: 9.2, rating: 5, poster: 'https://via.placeholder.com/200x300/805ad5/ffffff?text=Movie+3' },
  { id: 4, title: 'Inception', genre: 'Sci-Fi', year: 2010, language: 'English', score: 8.8, rating: 4, poster: 'https://via.placeholder.com/200x300/38b2ac/ffffff?text=Movie+4' },
  { id: 5, title: 'Parasite', genre: 'Thriller', year: 2019, language: 'Korean', score: 8.6, rating: 4, poster: 'https://via.placeholder.com/200x300/f56565/ffffff?text=Movie+5' },
  { id: 6, title: 'Spirited Away', genre: 'Adventure', year: 2001, language: 'Japanese', score: 9.3, rating: 5, poster: 'https://via.placeholder.com/200x300/4299e1/ffffff?text=Movie+6' },
  { id: 7, title: 'Casablanca', genre: 'Romance', year: 1942, language: 'English', score: 8.5, rating: 4, poster: 'https://via.placeholder.com/200x300/48bb78/ffffff?text=Movie+7' },
  { id: 8, title: 'The Shining', genre: 'Horror', year: 1980, language: 'English', score: 8.4, rating: 4, poster: 'https://via.placeholder.com/200x300/667eea/ffffff?text=Movie+8' },
  { id: 9, title: 'La La Land', genre: 'Romance', year: 2016, language: 'English', score: 8.0, rating: 4, poster: 'https://via.placeholder.com/200x300/fc8181/ffffff?text=Movie+9' },
  { id: 10, title: 'Mad Max: Fury Road', genre: 'Action', year: 2015, language: 'English', score: 8.1, rating: 4, poster: 'https://via.placeholder.com/200x300/fbb6ce/ffffff?text=Movie+10' },
  { id: 11, title: 'Amélie', genre: 'Romance', year: 2001, language: 'French', score: 8.3, rating: 4, poster: 'https://via.placeholder.com/200x300/68d391/ffffff?text=Movie+11' },
  { id: 12, title: 'Seven', genre: 'Thriller', year: 1995, language: 'English', score: 8.6, rating: 4, poster: 'https://via.placeholder.com/200x300/a78bfa/ffffff?text=Movie+12' }
])

// Computed properties
const filteredAndSortedMovies = computed(() => {
  let filtered = [...movies.value]
  
  // Apply filters
  if (selectedGenre.value !== 'All') {
    filtered = filtered.filter(movie => movie.genre === selectedGenre.value)
  }
  
  if (selectedYear.value !== 'All') {
    filtered = filtered.filter(movie => movie.year.toString() === selectedYear.value)
  }
  
  if (selectedLanguage.value !== 'All') {
    filtered = filtered.filter(movie => movie.language === selectedLanguage.value)
  }
  
  return filtered
})

// Methods
const toggleDropdown = (dropdownName) => {
  // Close all other dropdowns
  Object.keys(dropdowns.value).forEach(key => {
    if (key !== dropdownName) {
      dropdowns.value[key] = false
    }
  })
  
  // Toggle the selected dropdown
  dropdowns.value[dropdownName] = !dropdowns.value[dropdownName]
}

const selectGenre = (genre) => {
  selectedGenre.value = genre
  dropdowns.value.genre = false
}

const selectYear = (year) => {
  selectedYear.value = year
  dropdowns.value.year = false
}

const selectLanguage = (language) => {
  selectedLanguage.value = language
  dropdowns.value.language = false
}

const selectSortBy = (sortBy) => {
  selectedSortBy.value = sortBy
  dropdowns.value.sortBy = false
}

const selectSortOrder = (order) => {
  selectedSortOrder.value = order
  dropdowns.value.sortOrder = false
}

const sortMovies = () => {
  let sortKey = ''
  
  switch (selectedSortBy.value) {
    case 'Movie Score':
      sortKey = 'score'
      break
    case 'Release Date':
    case 'Year':
      sortKey = 'year'
      break
    case 'Title':
      sortKey = 'title'
      break
    case 'Rating':
      sortKey = 'rating'
      break
    default:
      sortKey = 'score'
  }
  
  movies.value.sort((a, b) => {
    let valueA = a[sortKey]
    let valueB = b[sortKey]
    
    if (typeof valueA === 'string') {
      valueA = valueA.toLowerCase()
      valueB = valueB.toLowerCase()
    }
    
    if (selectedSortOrder.value === 'Ascending') {
      return valueA > valueB ? 1 : valueA < valueB ? -1 : 0
    } else {
      return valueA < valueB ? 1 : valueA > valueB ? -1 : 0
    }
  })
}

// Lifecycle hooks
onMounted(() => {
  // Close dropdowns when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
      Object.keys(dropdowns.value).forEach(key => {
        dropdowns.value[key] = false
      })
    }
  })
})
</script>

<style>
/* Add any custom styles here if needed */
</style>