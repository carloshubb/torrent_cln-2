<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import AppLayout from './../layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, reactive, nextTick } from 'vue'

// Refs
const showModal = ref(false)
const imageUrl = ref('')
const descriptionTextarea = ref(null)
const imageUrlInput = ref(null)

// Form data
const form = reactive({
    language: 'English',
    type: 'Choose Category',
    category: 'Choose One',
    tags: '',
    description: ''
})

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

// Submit torrent
const submitTorrent = () => {
    console.log('Torrent data:', form)
    // Add your submission logic here
    alert('Torrent upload functionality would be implemented here!')
}
</script>

<template>

    <Head title="Your Torrents Uploads" />
    <AppLayout>
        <div class="max-w-4xl mx-auto p-6  min-h-screen">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Torrent</h1>

                <div class="space-y-6 text-black">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input v-model="form.title" type="text" placeholder="enter torrent title here"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select v-model="form.category"
                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Choose One</option>
                                <option>Action</option>
                                <option>Comedy</option>
                                <option>Drama</option>
                                <option>Horror</option>
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Please select which category best fits your torrent.
                            </p>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                        <input v-model="form.tags" type="text" placeholder="enter torrent tags here"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <p class="text-sm text-gray-500 mt-1">Tags examples: thriller,action,comedy (you can add 2 to 8 tags, don't forget to separate them with ",")</p>
                    </div>

                    <!-- Torrent Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Torrent Description</label>

                        <!-- Toolbar -->
                        <div class="border border-gray-300 rounded-t-md bg-gray-50 p-2 flex flex-wrap gap-1">
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
                        <textarea ref="descriptionTextarea" v-model="form.description"
                            class="w-full h-64 p-3 border border-gray-300 border-t-0 rounded-b-md resize-vertical focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter your torrent description here..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button @click="submitTorrent"
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
                    <h3 class="text-lg font-semibold mb-4">1331x.to says</h3>
                    <p class="mb-4">Enter the image URL:</p>
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
