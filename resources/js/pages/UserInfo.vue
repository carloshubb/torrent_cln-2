<script setup>
import { reactive, onMounted, ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import AppLayout from './../layouts/AppLayout.vue'
import TorrentPagination from '../Compenents/TorrentPagination.vue'
// get props data
const props = defineProps({
    data: Array
});
// some data in parent
const torrents = reactive([])
const userInfo = reactive({})
const page_type = "user"
const currentPage = props.data.torrents.current_page;
const lastPage = props.data.torrents.last_page;
const parseDateString = (str) => {
  const now = dayjs();

  // 1. ISO or already valid → just return
  if (dayjs(str).isValid()) {
    return dayjs(str);
  }

  // 2. Clean up "human style" strings
  str = str.trim();
  str = str.replace(/(\d+)(st|nd|rd|th)/gi, '$1');     // remove suffixes
  str = str.replace(/'(\d{2})/, '20$1');               // fix '25 → 2025
  str = str.replace(/\./g, '');                        // remove dots

  // 3. If only time → use today
  if (/^\d{1,2}(:\d{2})?(am|pm)$/i.test(str)) {
    return dayjs(
      `${now.format("YYYY-MM-DD")} ${str}`,
      ["YYYY-MM-DD h:mma", "YYYY-MM-DD ha"],
      true
    );
  }

  // 4. Try multiple known formats
  const formats = [
    "ha MMM D YYYY",
    "h:mma MMM D YYYY",
    "MMM D YYYY ha",
    "MMM D YYYY h:mma",
    "MMM D YYYY"
  ];

  let parsed = dayjs(str, formats, true);
  if (parsed.isValid()) {
    return parsed;
  }

  // 5. Fallback: let dayjs try to auto-parse
  parsed = dayjs(str);
  if (parsed.isValid()) {
    return parsed;
  }

  // 6. Totally invalid → return null
  return null;
};

const formatApprovedAt = (dateString) => {
  const date = parseDateString(dateString);
  if (!date) {
    return "Invalid date"; // gracefully handle garbage like 1337.com
  }

  const now = dayjs();
  if (date.isSame(now, "day")) {
    return date.format("h:mma"); // if today → just time
  } else {
    return date.format("MMM. D YYYY"); // add year
  }
};
const getAge = (birthdayString) => {
  const birthday = dayjs(birthdayString);
  if (!birthday.isValid()) return null;
  return dayjs().diff(birthday, 'year'); // difference in years
};

//const torrents = props.data.torrent.data
// Run fetch on component mount
onMounted(() => {
    //torrents = props.data.torrent;
    torrents.value = props.data.torrents.data
    userInfo.value = props.data.info
    console.log(userInfo.value);
    // torrents.value = props.data.torrent.data;

})
</script>
<template>

    <Head :title=$page.props.title />
    <AppLayout>
        <div class="flex-1" v-if="userInfo.value">
            <!-- Title -->
            <div class="bg-gray-700 px-4 py-2 mb-4 rounded">
                <h1 class="text-lg font-semibold">{{ userInfo.value.username }}</h1>
            </div>

            <!-- Torrent Info -->
            <div class="bg-gray-800 rounded mb-4">
                <div class="grid grid-cols-2 gap-4 p-4 text-sm">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Username:</span>
                            <span>{{ userInfo.value.username }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">User Rank:</span>
                            <span>{{ userInfo.value.rank }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Privacy:</span>
                            <span>{{ userInfo.value.privacy }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Join Date:</span>
                            <span>{{ formatApprovedAt(userInfo.value.joindate) }}</span>
                        </div>
                       
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Age:</span>
                            <span>{{ getAge(userInfo.value.birthday) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Gender:</span>
                            <span>{{ userInfo.value.gender }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Country:</span>
                            <span>{{ userInfo.value.country }}</span>
                        </div>
                        
                    </div>
                </div>

                
            </div>
        </div>
        <div class="px-2 md:px-0">
            <!-- Popular Torrents Section -->
            <div class="featured-list bg-gray-800 rounded-lg overflow-hidden shadow-xl mt-6">


                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="text-left px-4 py-1 text-gray-300 font-semibold">name</th>
                                <th class="hidden md:table-cell text-center px-4 py-1 text-gray-300 font-semibold">se
                                </th>
                                <th class="hidden md:table-cell text-center px-4 py-1 text-gray-300 font-semibold">le
                                </th>
                                <th class="hidden md:table-cell text-center px-4 py-1 text-gray-300 font-semibold">time
                                </th>
                                <th class="hidden md:table-cell text-center px-4 py-1 text-gray-300 font-semibold">size
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(torrent, index) in torrents.value" :key="index"
                                class="border-b border-gray-700 hover:bg-gray-750 transition-colors cursor-pointer text-xs">
                                <td class="px-2 py-3" v-if="page_type != 'top' && page_type != 'trending'">
                                    <div class="flex items-center justify-between ">
                                        <!-- Left side: icon + name -->
                                        <div class="flex items-center">
                                            <a :href="`/sub/${torrent.subcategory_id}/0/`">
                                                <button class="" v-if="torrent.subcategory"><i
                                                        :class="`${torrent.subcategory.icon}`"></i></button>
                                            </a>
                                            <a :href="`/torrent/${torrent.id}/${torrent.slug}/`"
                                                class="text-gray-300 hover:text-orange-400 transition-colors ml-3">
                                                {{ torrent.name }}
                                            </a>
                                        </div>

                                        <!-- Right side: badge -->
                                        <span v-if="torrent.comments_count"
                                            class="bg-gray-500 text-black-900 rounded text-xs font-semibold px-2">
                                            {{ torrent.comments_count }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-2 py-3" v-if="page_type == 'top' || page_type == 'trending'">
                                    <div class="flex items-center justify-between ">
                                        <!-- Left side: icon + name -->
                                        <div class="flex items-center">
                                            <a :href="`/sub/${torrent.subcategory_id}/0/`">
                                                <button class="" v-if="torrent.subcategory"><i
                                                        :class="`${torrent.subcategory.icon}`"></i></button>
                                            </a>
                                            <a :href="`${torrent.torrent_link}`"
                                                class="text-gray-300 hover:text-orange-400 transition-colors ml-3">
                                                {{ torrent.name }}
                                            </a>
                                        </div>

                                        <!-- Right side: badge -->
                                        <span v-if="torrent.comments_count"
                                            class="bg-gray-500 text-black-900 rounded text-xs font-semibold px-2">
                                            {{ torrent.comments_count }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center px-2 py-2 hidden md:table-cell">
                                    <span class="bg-green-600 text-white px-1 text-xs rounded ">
                                        {{ torrent.seeders }}
                                    </span>
                                </td>
                                <td class="text-center px-2 py-2 hidden md:table-cell">
                                    <span class="bg-red-800 text-white px-1 text-xs rounded ">
                                        {{ torrent.leechers }}
                                    </span>
                                </td>
                                <td class="text-center px-2 py-2 text-gray-400 hidden md:table-cell">
                                    {{ formatApprovedAt(torrent.approved_at) }}
                                </td>
                                <td class="text-center px-2 py-2 text-gray-400 hidden md:table-cell">
                                    {{ torrent.size_formatted }}
                                </td>

                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination component -->
                    <TorrentPagination :currentPage="currentPage" :lastPage="lastPage" @page-changed="onPageChange" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
