<template>
  <div class="bg-[url(../../images/main-bg.png)] bg-local">
  <div class="min-h-[40px] bg-[#000] border-b-5 border-[#822a0b] items-center ">
    <div class="mx-auto w-full grid-cols-1 gap-10 container text-right ">
      <a href="" class="title text-white hover:text-red-600">Register</a>
      |
      <a href="" class="title text-red-600 hover:text-red-600">Login</a>
    </div>
  </div>

  <div class="mx-auto container inset-x-0 z-20 flex h-14 items-center justify-between ">
    <div class="mt-6 bg-[#500] flex max-w-md gap-x-4">
      <img src="../../images/logo.svg" alt="">
    </div>
    <div class="mt-6 flex max-w-md gap-x-4">
      <input type="text" placeholder="Search for torrents..." class="min-w-0 flex-auto rounded-md bg-white/5 px-3.5 py-2 text-base outline-1 -outline-offset-1  placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
      <button class="bg-orange-500 px-3 py-1 rounded">Search</button>
    </div>
 
  </div>

  <div class=" mx-auto w-full grid-cols-1 gap-10  pt-10 md:pb-24 container">
     <nav class="bg-black text-white px-6 py-4 flex justify-between items-center">
      <div class="text-2xl font-bold text-orange-500">1337X</div>
      <div class="space-x-50 ">
        <a href="#" class="hover:text-orange-500">Home</a>
        <a href="#" class="hover:text-orange-500">Upload</a>
        <a href="#" class="hover:text-orange-500">Rules</a>
        <a href="#" class="hover:text-orange-500">Contact</a>
        <a href="#" class="hover:text-orange-500">About Us</a>
      </div>
      <div class="flex items-center space-x-2">
       
      </div>
    </nav>
    
     
       <main class="flex-1 p-6">
        <!-- Notification Banner -->
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
          Stream.to file error — some users are being redirected by Cloudflare.
        </div>
        <!-- Movie Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
          <div v-for="n in 6" :key="n" class="bg-white rounded shadow p-2">
            <img src="https://via.placeholder.com/150x220" alt="Movie Poster" class="w-full rounded" />
            <p class="text-center mt-2 text-sm">1080p</p>
          </div>
        </div>
        <aside class="w-64 bg-white p-4 border-r border-gray-200">
        <h2 class="font-bold mb-2">Browse Torrents</h2>
        <ul class="space-y-1 text-sm">
          <li><a href="#" class="text-blue-500 hover:underline">Trending Torrents</a></li>
          <li><a href="#" class="text-blue-500 hover:underline">Movie Library</a></li>
          <li><a href="#" class="text-blue-500 hover:underline">Top 100 Torrents</a></li>
          <li><a href="#" class="text-blue-500 hover:underline">Anime</a></li>
          <li><a href="#" class="text-blue-500 hover:underline">Applications</a></li>
          <li><a href="#" class="text-blue-500 hover:underline">Documentaries</a></li>
          <li><a href="#" class="text-blue-500 hover:underline">Games</a></li>
          <li><a href="#" class="text-blue-500 hover:underline">Music</a></li>
          <li><a href="#" class="text-blue-500 hover:underline">Other</a></li>
          <li><a href="#" class="text-blue-500 hover:underline">Television</a></li>
        </ul>
      </aside>

        

        <!-- Torrent Table -->
        <h2 class="text-lg font-bold mb-2">Most Popular Torrents This Week</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-left bg-white shadow rounded">
            <thead>
              <tr class="bg-gray-200">
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">SE</th>
                <th class="px-4 py-2">LE</th>
                <th class="px-4 py-2">Time</th>
                <th class="px-4 py-2">Size</th>
                <th class="px-4 py-2">Uploader</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="n in 5" :key="n" class="border-t">
                <td class="px-4 py-2 text-blue-600 hover:underline cursor-pointer">Example Torrent {{ n }}</td>
                <td class="px-4 py-2">1000</td>
                <td class="px-4 py-2">500</td>
                <td class="px-4 py-2">1 day ago</td>
                <td class="px-4 py-2">1.4 GB</td>
                <td class="px-4 py-2">Uploader{{ n }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        
      </main>
     
  </div>
  </div>
</template>
