<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import AppLayout from './../layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, reactive, nextTick } from 'vue'
import 'toastr/build/toastr.min.css'
import toastr from 'toastr'

// Refs
const showModal = ref(false)
const imageUrl = ref('')
const descriptionTextarea = ref(null)
const imageUrlInput = ref(null)
const { props } = usePage()
const torrent = ref(props.torrent)

console.log('torrent----->', torrent.value);

// Optional: configure toastr defaults
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    timeOut: 3000
}
function showError() {
    toastr.error('Something went wrong.', 'Error')
}

// Form data
const form = reactive({
    language: 'English',
    type: 'Choose Category',
    category: 'Choose One',
    tags: '',
    description: ''
})


//console.log(torrent.value);

// Insert tag function
const insertTag = (openTag, closeTag = '') => {
    const textarea = descriptionTextarea.value
    const start = textarea.selectionStart
    const end = textarea.selectionEnd
    const selectedText = textarea.value.substring(start, end)

    let newText
    if (closeTag) {
        newText = textarea.value.substring(0, start) +
            openTag + selectedText + closeTag +
            textarea.value.substring(end)
    } else {
        newText = textarea.value.substring(0, start) +
            openTag +
            textarea.value.substring(end)
    }

    form.description = newText

    // Set cursor position after insertion
    nextTick(() => {
        const newPosition = closeTag ? start + openTag.length : start + openTag.length
        textarea.setSelectionRange(newPosition, closeTag ? newPosition + selectedText.length : newPosition)
        textarea.focus()
    })
}

// Show image modal
const showImageModal = () => {
    showModal.value = true
    nextTick(() => {
        imageUrlInput.value?.focus()
    })
}

// Hide image modal
const hideImageModal = () => {
    showModal.value = false
    imageUrl.value = ''
}

// Confirm image URL
const confirmImageUrl = () => {
    if (imageUrl.value.trim()) {
        insertTag(`[img]${imageUrl.value}[/img]`)
        hideImageModal()
    }
}

// Insert URL
const insertUrl = () => {
    const url = prompt('Enter URL:')
    if (url) {
        insertTag(`[url=${url}]`, '[/url]')
    }
}

// Insert YouTube
const insertYouTube = () => {
    const videoId = prompt('Enter YouTube video ID:')
    if (videoId) {
        insertTag(`[youtube]${videoId}[/youtube]`)
    }
}

// save torrent
async function saveTorrent() {
    //console.log("--------->",torrent.value);

    const response = await fetch('/savetorrent', {
        method: 'POST',
        body: JSON.stringify({ torrent: torrent.value }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });
    toastr.success('Data saved successfully!', 'Success')
    let prevPath = null;

    if (document.referrer) {
        try {
            const refUrl = new URL(document.referrer);
            prevPath = refUrl.pathname + refUrl.search + refUrl.hash;
            // e.g. "/option/1/2?foo=bar#section"
        } catch (e) {
            console.warn("Invalid referrer:", e);
        }
    }

    // console.log("Previous path:", prevPath);
    window.location.href = prevPath;
    //window.history.go(-1);

}
</script>

<template>

    <Head title="Your Torrents Uploads" />
    <AppLayout>
        <div class="max-w-4xl mx-auto p-6   min-h-screen">
            <div class="bg-gray-800 rounded-lg text-white shadow-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-white">Edit Torrent</h1>

                <div class="space-y-6 ">
                    
                    <!--Html Title -->
                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">HTML Title</label>
                        <textarea v-model="torrent.name" placeholder="Enter HTML code here (e.g. <h1>My Title</h1>)"
                            rows="4"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div> -->
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">name</label>
                        <input v-model="torrent.name" type="text" placeholder="enter torrent title here"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <!-- seeders -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">seeders</label>
                        <input v-model="torrent.seeders" type="number" placeholder="enter torrent title here"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>


                    <!--leechers -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">leechers</label>
                        <input v-model="torrent.leechers" type="number" placeholder="enter torrent title here"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <!-- uploader -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">uploader</label>
                        <input v-model="torrent.detail.uploader" type="text" placeholder="enter torrent title here"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>
                    <!-- downloads -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">downloads</label>
                        <input v-model="torrent.detail.download_count" type="text"
                            placeholder="enter torrent title here"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>


                    <!-- Torrent Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Torrent Description</label>

                        <!-- Toolbar -->
                        <div class="border border-gray-300 rounded-t-md bg-gray-500 p-2 flex flex-wrap gap-1">
                            <button type="button" @click="insertTag('[b]', '[/b]')"
                                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200 font-bold"
                                title="Bold">
                                B
                            </button>
                            <button type="button" @click="insertTag('[i]', '[/i]')"
                                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200 italic"
                                title="Italic">
                                I
                            </button>
                            <button type="button" @click="insertTag('[u]', '[/u]')"
                                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200 underline"
                                title="Underline">
                                U
                            </button>
                            <button type="button" @click="insertTag('[list]\n[*] Item 1\n[*] Item 2\n[/list]\n')"
                                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200" title="List">
                                ≡
                            </button>
                            <button type="button" @click="insertTag('[quote]', '[/quote]')"
                                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200" title="Quote">
                                ❝❞
                            </button>
                            <button type="button" @click="insertTag('[code]', '[/code]')"
                                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200 font-mono"
                                title="Code">
                                &lt;/&gt;
                            </button>
                            <button type="button" @click="showImageModal"
                                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200" title="Image">
                                img
                            </button>
                            <button type="button" @click="insertUrl"
                                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200" title="URL">
                                🔗
                            </button>
                            <button type="button" @click="insertYouTube"
                                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200" title="YouTube">
                                YouTube
                            </button>
                        </div>

                        <!-- Textarea -->
                        <textarea ref="descriptionTextarea" v-model="torrent.detail.full_description"
                            class="w-full h-64 p-3 border border-gray-300 border-t-0 rounded-b-md resize-vertical focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter your torrent description here..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">

                        <button @click="saveTorrent"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Save Torrent
                        </button>
                    </div>
                </div>
            </div>


            <!-- Image URL Modal -->
            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                @click="hideImageModal">
                <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4" @click.stop>
                    <h3 class="text-lg text-black font-semibold mb-4">1331x.to says</h3>
                    <p class="mb-4 text-black">Enter the image URL:</p>
                    <input v-model="imageUrl" type="text"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-4"
                        placeholder="Enter image URL..." @keyup.enter="confirmImageUrl" ref="imageUrlInput" />
                    <div class="flex justify-end gap-3">
                        <button @click="hideImageModal"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button @click="confirmImageUrl"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            OK
                        </button>

                    </div>
                </div>
            </div>
        </div>



    </AppLayout>
</template>
