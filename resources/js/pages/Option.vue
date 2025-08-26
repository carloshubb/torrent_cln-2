<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import AppLayout from './../layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import torrentService from '@/api/torrentService.js'
import { ref, reactive, nextTick } from 'vue'
import relativeTime from 'dayjs/plugin/relativeTime'
import TorrentPagination from '../Compenents/TorrentPagination.vue'
import dayjs from 'dayjs'


const { props } = usePage()
const category = ref(props.category)
const torrents = ref(props.torrents.data)
const sel_category = ref(props.sel_category)
const sel_subcategory = ref(props.sel_subcategory)
const subcategory = ref(props.subcategories)

const currentPage = props.torrents.current_page
const lastPage = props.torrents.last_page// default to 7 if not passe
//console.log("----->",props.torrents.data)
// Form data'
const form = reactive({
  language: 'English',
  type: 'Choose Category',
  category: sel_category.value,
  subcategory: sel_subcategory.value,
  tags: '',
})

dayjs.extend(relativeTime)
const parseDateString = (str) => {
    const now = dayjs();
    // If it's ISO string, parse directly
    if (dayjs(str, dayjs.ISO_8601, true).isValid()) {
        return dayjs(str);
    }

    // Remove ordinal suffixes
    str = str.replace(/(\d+)(st|nd|rd|th)/gi, '$1');

    // Remove apostrophe year and fix
    str = str.replace(/'(\d{2})/, '20$1');

    // Remove dots from months
    str = str.replace(/\./g, '');

    // If only time is provided, use today
    if (/^\d{1,2}(:\d{2})?(am|pm)$/i.test(str)) {
        return dayjs(
            `${now.format("YYYY-MM-DD")} ${str}`,
            ["YYYY-MM-DD h:mma", "YYYY-MM-DD ha"]
        );
    }

    // Try multiple formats
    const formats = [
        "ha MMM D YYYY",
        "h:mma MMM D YYYY",
        "MMM D YYYY ha",
        "MMM D YYYY h:mma",
        "MMM D YYYY" // no time
    ];

    return dayjs(str, formats);
};
 const formatApprovedAt = (dateString) => {
      if(dateString) dateString = dateString.split('.')[0]; // Remove timezone if present
      else return 'last year'; // Handle case where dateString is null or undefined
      const date = parseDateString(dateString);
      const now = dayjs();
      if (date.isSame(now, 'day')) {
        return date.format('h:mma');
      } else {
        return date.format('ha MMM. D');
      }
    };
const fetchcategory = async () => {

  if (!form.category) return

  try {
    const response = await torrentService.get(`/option/category?category=${form.category}`);

    subcategory.value = response.data ? response.data.subcategory : [];
  } catch (error) {
    console.error('Failed to fetch torrents:', error)
  }
}
const onPageChange = (page) => {
 // console.log(page);
  
  if (page >= 1 && page <= lastPage.value) {
    currentPage.value = page
  }
}
const torrentTable = async () => {
  //console.log(`/option/${form.subcategory}/1`);  
  window.location.href = `/option/${form.subcategory}/1`;
}
const detailTorrent = async (id) => {

  window.location.href = `/edit/${id}`;
}

if (performance.navigation.type === performance.navigation.TYPE_BACK_FORWARD) {
  location.reload(); // force refresh if user came back
}

</script>

<template>

  <Head title="Your Torrents Uploads" />
  <AppLayout>
    <div class="max-w-full bg-gray-800 rounded-lg overflow-hidden shadow-xl mt-6 ">
      <!-- option -->
      <div class="flex gap-2 border-gray-700">
      <div  class="border border-gray-300 rounded p-2 flex-1">
        <label class="block text-sm font-medium text-gray-200 mb-2 mt-3">Category</label>
        <select v-model="form.category" @change="fetchcategory"
          class="p-2 border border-gray-300 bg-gray-700 rounded-md focus:ring-2  focus:ring-blue-500 focus:border-blue-500">

          <option v-for="item in category" :key="item" :value="item.id"
          class="bg-gray-700">
            {{ item.name }}
          </option>

        </select>

      </div>
      <div   class="border border-gray-300 rounded p-2 flex-1">
        <label class="block text-sm font-medium text-gray-200 mb-2">SubCategory</label>
        <select v-model="form.subcategory" @change="torrentTable"
          class=" p-2 border border-gray-300 bg-gray-700 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

          <option v-for="item in subcategory" :key="item" :value="item.id"  class="bg-gray-700">
            {{ item.name }}
          </option>

        </select>

      </div>
      </div>
      <div class="overflow-x-auto mt-8">
        <table class="min-w-full boder-black">
          <thead class="bg-gradient-to-r from-orange-400 to-red-500 ">
            <tr>
              <th class="text-left px-4 py-1 text-gray-300 font-semibold">name</th>
              <th class="hidden md:table-cell text-center px-4 py-1 text-gray-300 font-semibold">se</th>
              <th class="hidden md:table-cell text-center px-4 py-1 text-gray-300 font-semibold">le</th>
              <th class="hidden md:table-cell text-center px-4 py-1 text-gray-300 font-semibold">time</th>
              <th class="hidden md:table-cell text-center px-4 py-1 text-gray-300 font-semibold">size</th>
              <th class="text-center px-4 py-1 text-gray-300 font-semibold">uploader</th>
            </tr>
          </thead>
          <tbody class="table-auto border-collapse border border-gray-500">
            <tr v-for="(torrent, index) in torrents" :key="index"
              class="border-b border-gray-700 hover:bg-gray-750 transition-colors cursor-pointer text-xs"
              @click="detailTorrent(torrent.id)">
              <td class="px-2 py-3">
                <div class="flex items-center justify-between ">
                  <!-- Left side: icon + name -->
                  <div class="flex items-center">
                    {{ torrent.name }}
                  </div>
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
              <td class="text-center px-2 py-2">
                <a>
                  <span class="text-orange-400 hover:text-orange-300 transition-colors">
                    {{ torrent.uploader?.split('/')[2] }}
                  </span>
                </a>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Pagination component -->
        <TorrentPagination :currentPage="currentPage" :lastPage="lastPage" @page-changed="onPageChange" />
      </div>

    </div>



  </AppLayout>
</template>
