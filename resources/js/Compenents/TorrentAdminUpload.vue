<template>
  <div class="pt-5  bg-gray-300 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-orange-400 to-red-500 text-white">
      <div class="container mx-auto px-4 py-3">
        <h1 class="text-2xl font-bold">Recent Uploads</h1>
      </div>
      <nav class="bg-black bg-opacity-20">
        <div class="container mx-auto px-4">
          <ul class="flex space-x-6 py-2 text-sm">
            <li><a href="#" class="hover:text-orange-200 transition-colors">Home</a></li>
            <li><a href="#" class="hover:text-orange-200 transition-colors">Categories</a></li>
            <li><a href="#" class="hover:text-orange-200 transition-colors">Archives</a></li>
            <li><a href="#" class="hover:text-orange-200 transition-colors">About</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Recent Uploads Section -->
    <div class="bg-gradient-to-r from-orange-300 to-red-400 text-white py-4">
      <div class="container mx-auto px-4">
        <h2 class="text-lg font-semibold mb-3">Recent Uploads</h2>
        <div class="space-y-1 text-sm">
          <div v-for="post in recentPosts" :key="post.id">
            <span class="text-orange-100">•</span> 
            <a href="#" class="hover:text-orange-100 transition-colors ml-1">{{ post.title }}</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container  mx-auto px-4 py-8">
      <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-orange-400 pb-2">
          Create New Blog Post
        </h2>
        
        <form @submit.prevent="submitPost" class="space-y-6">
          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
            <input 
              type="text" 
              id="title" 
              v-model="form.title"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
              placeholder="Enter post title"
              required
            >
          </div>

          <!-- Content Text -->
          <div>
            <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Content Text</label>
            <textarea 
              id="content" 
              v-model="form.content"
              rows="6"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-vertical"
              placeholder="Enter your blog post content here..."
              required
            ></textarea>
          </div>

          <!-- Language and Category Row -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Language -->
            <div>
              <label for="language" class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
              <select 
                id="language" 
                v-model="form.language"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                required
              >
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
                  <select 
                    id="category" 
                    v-model="form.category"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                    required
                  >
                    <option value="">Choose One</option>
                    <option value="technology">Technology</option>
                    <option value="lifestyle">Lifestyle</option>
                    <option value="business">Business</option>
                    <option value="education">Education</option>
                    <option value="health">Health</option>
                  </select>
                </div>
                <div>
                  <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Type</label>
                  <select 
                    id="type" 
                    v-model="form.type"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                    required
                  >
                    <option value="">Choose category</option>
                    <option value="article">Article</option>
                    <option value="tutorial">Tutorial</option>
                    <option value="review">Review</option>
                    <option value="news">News</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Tags -->
          <div>
            <label for="tags" class="block text-sm font-semibold text-gray-700 mb-2">Tags</label>
            <input 
              type="text" 
              id="tags" 
              v-model="form.tags"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
              placeholder="Enter tags separated by commas"
            >
            <p class="text-xs text-gray-500 mt-1">Use commas to separate multiple tags (e.g., web design, css, html)</p>
          </div>

          <!-- Format Description -->
          <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Format Description</label>
            <div class="border border-gray-300 rounded-md p-3 bg-gray-50">
              <div class="flex flex-wrap gap-2 text-xs mb-3">
                <button 
                  type="button" 
                  v-for="tool in formatTools" 
                  :key="tool"
                  @click="applyFormat(tool)"
                  class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded transition-colors"
                >
                  {{ tool }}
                </button>
              </div>
              <textarea 
                ref="descriptionTextarea"
                v-model="form.description"
                rows="4"
                class="w-full px-3 py-2 border-0 bg-white rounded focus:outline-none focus:ring-2 focus:ring-orange-500 resize-vertical"
                placeholder="Enter formatted description here..."
              ></textarea>
            </div>
          </div>

          <!-- File Upload -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Image</label>
            <div 
              class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-orange-400 transition-colors"
              @dragover.prevent
              @drop.prevent="handleDrop"
            >
              <div class="inline-flex items-center px-4 py-2 rounded-lg text-white cursor-pointer hover:opacity-90 transition-opacity bg-gradient-to-r from-blue-500 to-purple-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Choose File
                <input 
                  type="file" 
                  ref="fileInput"
                  class="hidden" 
                  @change="handleFileUpload" 
                  accept="image/*"
                >
              </div>
              <p class="text-gray-500 text-sm mt-2">
                {{ selectedFileName || 'Upload an image for your blog post' }}
              </p>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end pt-6 border-t border-gray-200">
            <button 
              type="submit"
              :disabled="isSubmitting"
              class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-orange-300"
            >
              {{ isSubmitting ? 'UPLOADING...' : 'UPLOAD' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BlogPostForm',
  data() {
    return {
      isSubmitting: false,
      selectedFileName: '',
      recentPosts: [
        { id: 1, title: 'Post about new technology trends and innovations' },
        { id: 2, title: 'How to build modern web applications' },
        { id: 3, title: 'Best practices for responsive design' },
        { id: 4, title: 'Tips for improving website performance' }
      ],
      formatTools: ['Bold', 'Italic', 'Underline', 'Quote', 'Code', 'List', 'Link', 'Full Screen'],
      form: {
        title: '',
        content: '',
        language: '',
        category: '',
        type: '',
        tags: '',
        description: '',
        file: null
      }
    }
  },
  methods: {
    async submitPost() {
      this.isSubmitting = true;
      
      try {
        // Validate required fields
        if (!this.form.title || !this.form.content || !this.form.language || !this.form.category || !this.form.type) {
          alert('Please fill in all required fields');
          return;
        }

        // Prepare form data
        const formData = new FormData();
        Object.keys(this.form).forEach(key => {
          if (this.form[key]) {
            formData.append(key, this.form[key]);
          }
        });

        // Here you would typically make an API call
        // Example: await this.$http.post('/api/posts', formData);
        
        console.log('Submitting post:', this.form);
        
        // Simulate API call delay
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        alert('Blog post submitted successfully!');
        this.resetForm();
        
      } catch (error) {
        console.error('Error submitting post:', error);
        alert('Error submitting post. Please try again.');
      } finally {
        this.isSubmitting = false;
      }
    },

    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.file = file;
        this.selectedFileName = file.name;
        console.log('File selected:', file.name);
      }
    },

    handleDrop(event) {
      const files = event.dataTransfer.files;
      if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
          this.form.file = file;
          this.selectedFileName = file.name;
          console.log('File dropped:', file.name);
        } else {
          alert('Please select an image file');
        }
      }
    },

    applyFormat(tool) {
      const textarea = this.$refs.descriptionTextarea;
      const start = textarea.selectionStart;
      const end = textarea.selectionEnd;
      const selectedText = this.form.description.substring(start, end);
      
      let formattedText = '';
      
      switch (tool) {
        case 'Bold':
          formattedText = `**${selectedText}**`;
          break;
        case 'Italic':
          formattedText = `*${selectedText}*`;
          break;
        case 'Underline':
          formattedText = `<u>${selectedText}</u>`;
          break;
        case 'Quote':
          formattedText = `> ${selectedText}`;
          break;
        case 'Code':
          formattedText = `\`${selectedText}\``;
          break;
        case 'List':
          formattedText = `- ${selectedText}`;
          break;
        case 'Link':
          formattedText = `[${selectedText}](url)`;
          break;
        default:
          formattedText = selectedText;
      }
      
      this.form.description = 
        this.form.description.substring(0, start) + 
        formattedText + 
        this.form.description.substring(end);
      
      // Focus back to textarea
      this.$nextTick(() => {
        textarea.focus();
        textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
      });
    },

    resetForm() {
      this.form = {
        title: '',
        content: '',
        language: '',
        category: '',
        type: '',
        tags: '',
        description: '',
        file: null
      };
      this.selectedFileName = '';
      this.$refs.fileInput.value = '';
    }
  }
}
</script>

<style scoped>
/* Custom styles if needed */
.custom-file-input {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>