<template>
  <div class="pt-5 bg-gradient-to-r from-gray-350 to-gray-500">
    <div class="max-w-4xl mx-auto">

      <!-- Success Toast -->
      <div v-if="showToast"
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300"
        :class="{ 'translate-y-0 opacity-100': showToast, 'translate-y-2 opacity-0': !showToast }">
        <div class="flex items-center">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
              clip-rule="evenodd"></path>
          </svg>
          URL copied to clipboard!
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-orange-400 pb-2">
          Create New Blog Post
        </h2>

        <form @submit.prevent="submitPost" class="space-y-6 text-black">
          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
            <input type="text" id="title" v-model="form.title"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
              placeholder="Enter post title" required>
          </div>

          <!-- Torrent File Upload -->
          <div>
            <label for="torrentFile" class="block text-sm font-semibold text-black mb-2">Torrent File</label>
            <div class="flex items-center space-x-3">
              <!-- Hidden file input -->
              <input type="file" ref="fileInput" id="torrentFile" @change="handleFileSelect" accept=".torrent"
                class="hidden">

              <!-- Display selected file path -->
              <input type="text" v-model="selectedFilePath" readonly
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none"
                placeholder="No file selected">

              <!-- Browse button -->
              <button type="button" @click="openFileDialog"
                class="bg-gray-600 hover:bg-orange-500 text-white font-bold px-4 py-2 rounded transition-colors">
                Browse
              </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">Select a .torrent file to upload</p>
          </div>

          <!-- Content Text -->
          <div>
            <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Content Text</label>
            <textarea id="content" v-model="form.content" rows="6"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-vertical"
              placeholder="Enter your blog post content here..." required></textarea>
          </div>

          <!-- Language and Category Row -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Language -->
            <div>
              <label for="language" class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
              <select id="language" v-model="form.language"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                required>
                <option value="">Choose language</option>
                <option value="english">English</option>
                <option value="spanish">Spanish</option>
                <option value="french">French</option>
                <option value="german">German</option>
                <option value="chinese">Chinese</option>
                <option value="japanese">Japanese</option>
              </select>
            </div>

            <!-- Category and Type -->
            <div>
              <div class="grid grid-cols-2 gap-3">
                <div>
                  <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                  <select id="category" v-model="form.category" @change="handleCategoryChange"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                    required>
                    <option value="">Choose One</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                      {{ cat.name }}
                    </option>
                  </select>

                </div>
                <div>
                  <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Type</label>
                  <select id="subcategory" v-model="form.subcategory"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                    required>
                    <option value="">Choose sub category</option>
                    <option v-for="item in sub_categories" :key="item.value" :value="item.id">
                      {{ item.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Tags -->
          <div>
            <label for="tags" class="block text-sm font-semibold text-gray-700 mb-2">Tags</label>
            <input type="text" id="tags" v-model="form.tags"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
              placeholder="Enter tags separated by commas">
            <p class="text-xs text-gray-500 mt-1">Use commas to separate multiple tags (e.g., web design, css, html)</p>
          </div>

          <!-- Format Description -->
          <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Format Description</label>
            <div class="border border-gray-300 rounded-md p-3 bg-gray-50">
              <div class="flex flex-wrap gap-2 text-xs mb-3">
                <button type="button" v-for="tool in formatTools" :key="tool" @click="applyFormat(tool)"
                  class="px-2 py-1 bg-gray-500 text-white hover:bg-gray-400 rounded transition-colors">
                  {{ tool }}
                </button>
              </div>
              <textarea ref="descriptionTextarea" v-model="form.description" rows="4"
                class="w-full px-3 py-2 border-2 bg-white rounded focus:outline-none focus:ring-2 focus:ring-orange-500 resize-vertical"
                placeholder="Enter formatted description here..."></textarea>
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
                <button @click="confirmImageUrl" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                  OK
                </button>
              </div>
            </div>
          </div>



          <!-- Submit Button -->
          <div class="flex justify-end pt-6 border-t border-gray-200">
            <button type="submit" :disabled="isSubmitting"
              class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-orange-300">
              {{ isSubmitting ? 'UPLOADING...' : 'UPLOAD' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, onMounted, ref } from 'vue'
const showModal = ref(false)
const imageUrl = ref('')
const descriptionTextarea = ref(null)
const imageUrlInput = ref(null)

export default {

  name: 'BlogPostForm',
  props: {
    categories: {
      type: Array
    }
  },
  data(props) {
    console.log(props.categories);
    const categories = ref([]);
    const sub_categories = ref([]);
    categories.value = props.categories ? props.categories : [];
    sub_categories.value = props.categories ? props.categories[0].subcategory : [];
    console.log(props.categories[0].subcategory);

    return {
      isSubmitting: false,
      selectedFilePath: '',
      showToast: false,
      copiedUrl: null,
      categories,
      sub_categories,
      announceUrls: [
        { id: 1, link: 'http://tracker.example.com:8080/announce' },
        { id: 2, link: 'http://tracker2.example.com:6969/announce' }
      ],
      formatTools: ['Bold', 'Italic', 'Underline', 'Quote', 'Code', 'List', 'Link', 'Full Screen', 'Image'],
      form: {
        title: '',
        content: '',
        language: '',
        category: '',
        subcategory: '',
        tags: '',
        description: '',
        torrentFile: null,
      }
    }
  },
  methods: {
    // Open file dialog
    openFileDialog() {
      this.$refs.fileInput.click();
    },
    // Open Image dialog
    openImageDialog() {
    showModal.value = true
    },

    // Handle file selection
    handleFileSelect(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.torrentFile = file;
        this.selectedFilePath = file.name; // Show just filename for security

        // For debugging - you can see full file info in console
        console.log('Selected file:', {
          name: file.name,
          size: file.size,
          type: file.type,
          lastModified: new Date(file.lastModified)
        });

        this.showToast = true;
        setTimeout(() => this.showToast = false, 3000);
      }
    },

    // Submit form with file
    async submitPost() {
      this.isSubmitting = true;
      console.log(this.form);

      try {
        // Validate required fields
        if (!this.form.title || !this.form.content || !this.form.language ||
          !this.form.category || !this.form.subcategory || !this.form.torrentFile) {
          alert('Please fill in all required fields and select a torrent file');
          return;
        }



        // Prepare FormData for file upload
        const formData = new FormData();

        // Add all form fields
        Object.keys(this.form).forEach(key => {
          if (key === 'torrentFile' && this.form[key]) {
            formData.append('torrent_file', this.form[key]);
          } else if (this.form[key] && key !== 'torrentFile') {
            formData.append(key, this.form[key]);
          }
        });

        // Laravel API call example
        const response = await fetch('/torrents', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            // Don't set Content-Type header - let browser set it with boundary for FormData
          }
        });
        this.resetForm();
        this.isSubmitting = false;
        if (response.success) {
          const result = await response.json();
          //alert('Torrent uploaded successfully!');
          this.resetForm();
        } else {
          throw new Error('Upload failed');
        }

      } catch (error) {
        //console.error('Error submitting post:', error);
        //alert('Error uploading torrent. Please try again.');
      } finally {
        this.isSubmitting = false;
      }
    },

    // Copy URL to clipboard
    async copyToClipboard(text) {
      try {
        await navigator.clipboard.writeText(text);
        const urlObj = this.announceUrls.find(url => url.link === text);
        this.copiedUrl = urlObj.id;
        setTimeout(() => this.copiedUrl = null, 2000);
      } catch (err) {
        console.error('Failed to copy: ', err);
      }
    },

    // Apply text formatting
    applyFormat(tool) {
      const textarea = this.$refs.descriptionTextarea;
      const start = textarea.selectionStart;
      const end = textarea.selectionEnd;
      const selectedText = this.form.description.substring(start, end);

      let formattedText = '';     
        switch (tool) {
          case 'Bold':
            formattedText = `<b>${selectedText}</b>`;
            break;
          case 'Italic':
            formattedText = `<p style = 'font-style: italic'>${selectedText}</p>`;
            break;
          case 'Underline':
            formattedText = `<p style = 'text-decoration: underline'>${selectedText}</p>`;
            break;
          case 'Quote':
            formattedText = `<blockquote> ${selectedText}</blockquote>`;
            break;
          case 'Code':
            formattedText = `<code>${selectedText}</code>`;
            break;
          case 'List':
            formattedText = `<ul><li>${selectedText}</li></ul>`;
            break;
          case 'Link':
            formattedText = `<a href = '${selectedText}' ></a>`;
            break;
          case 'Image':
            formattedText = `<img src = ${selectedText} />`;
            break;
          default:
            formattedText = selectedText;
        }

    

      this.form.description =
        this.form.description.substring(0, start) +
        formattedText +
        this.form.description.substring(end);

      this.$nextTick(() => {
        textarea.focus();
        textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
      });
    },

    // Reset form
    resetForm() {
      this.form = {
        title: '',
        content: '',
        language: '',
        category: '',
        sub_categories: '',
        type: '',
        tags: '',
        description: '',
        torrentFile: null,
      };
      this.selectedFilePath = '';
      this.$refs.fileInput.value = '';

    },

    handleCategoryChange() {
      console.log(this.categories, this.form.category);

      const selected = this.categories.find(cat => cat.id === parseInt(this.form.category));
      this.sub_categories = selected ? selected.subcategory : [];
      console.log(selected);

      this.form.subcategory = ""; // reset subcategory
    }

  },

  mounted() {

  }
}
</script>

<style scoped>
.custom-file-input {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>