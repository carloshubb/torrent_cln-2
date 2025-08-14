<template>
  <div class="pt-5 bg-gradient-to-r from-gray-350 to-gray-500">
    <div class="max-w-4xl mx-auto">
      <!-- Account Upgrade Section -->
      <div class="bg-white rounded-lg shadow-sm border mb-6">
        <div class="bg-gradient-to-r from-gray-700 to-orange-500 text-white p-4 rounded-t-lg">
          <h2 class="text-xl font-semibold">Account Upgrade</h2>
        </div>
        <div class="p-6">
          <p class="text-gray-700 leading-relaxed">
            Once you upload 100+ torrents with good quality description you can request your account upgraded to
            verified Uploader.
          </p>
        </div>
      </div>

      <!-- Upload Torrent Section -->
      <div class="bg-white rounded-lg shadow-sm border">
        <div class="bg-gradient-to-r from-gray-700 to-orange-500 text-white p-4 rounded-t-lg">
          <h2 class="text-xl font-semibold">Want to upload a torrent? No problem! Please use the announce URLs:</h2>
        </div>
        <div class="p-6 space-y-3">
          <!-- Announce URLs List -->
          <div v-for="url in announceUrls" :key="url.id" class="group">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
              <a :href="url.link" class="text-orange-600 hover:text-orange-700 font-medium underline break-all flex-1"
                target="_blank" rel="noopener noreferrer">
                {{ url.link }}
              </a>
              <button @click="copyToClipboard(url.link)"
                class="ml-4 px-3 py-1 bg-orange-500 hover:bg-orange-600 text-white text-sm rounded transition-colors"
                :class="{ 'bg-green-500 hover:bg-green-600': copiedUrl === url.id }">
                {{ copiedUrl === url.id ? 'Copied!' : 'Copy' }}
              </button>
            </div>
          </div>

          <!-- Additional Information -->
          <div class="mt-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Important Information</h3>
                <p class="mt-1 text-sm text-blue-700">
                  Please use one of the announce URLs above when creating your torrent file. Make sure to include a
                  detailed description for better quality.
                </p>
              </div>
            </div>
          </div>

          <!-- Upload Guidelines -->
          <div class="mt-6 p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-yellow-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path>
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Upload Guidelines</h3>
                <ul class="mt-1 text-sm text-yellow-700 list-disc list-inside space-y-1">
                  <li>Ensure your torrent has a good quality description</li>
                  <li>Include relevant tags and categories</li>
                  <li>Use appropriate file naming conventions</li>
                  <li>Upload 100+ quality torrents to become a verified uploader</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

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
              <input 
                type="file" 
                ref="fileInput"
                id="torrentFile"
                @change="handleFileSelect"
                accept=".torrent"
                class="hidden"
              >
              
              <!-- Display selected file path -->
              <input 
                type="text" 
                v-model="selectedFilePath"
                readonly
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 focus:outline-none"
                placeholder="No file selected"
              >
              
              <!-- Browse button -->
              <button 
                type="button" 
                @click="openFileDialog"
                class="bg-gray-600 hover:bg-orange-500 text-white font-bold px-4 py-2 rounded transition-colors"
              >
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
                  <select id="category" v-model="form.category"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                    required>
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
                  <select id="type" v-model="form.type"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                    required>
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

          <!-- CAPTCHA -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Captcha</label>
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0">
                <div class="bg-gray-600 px-4 py-8 rounded border-2 border-gray-400 relative overflow-hidden">
                  <canvas ref="captchaCanvas" width="120" height="40" class="bg-gray-200 rounded"></canvas>
                  <button type="button" @click="refreshCaptcha"
                    class="absolute top-1 right-1 text-white hover:text-gray-300 text-xs" title="Refresh Captcha">
                    ⟲
                  </button>
                </div>
              </div>
              <div class="flex-1">
                <input type="text" v-model="form.captcha"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                  placeholder="Enter captcha code" maxlength="6" required>
                <p class="text-xs text-gray-500 mt-1">Enter the characters shown in the image above</p>
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
export default {
  name: 'BlogPostForm',
  data() {
    return {
      isSubmitting: false,
      selectedFilePath: '',
      captchaCode: '',
      showToast: false,
      copiedUrl: null,
      announceUrls: [
        { id: 1, link: 'http://tracker.example.com:8080/announce' },
        { id: 2, link: 'http://tracker2.example.com:6969/announce' }
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
        torrentFile: null,
        captcha: ''
      }
    }
  },
  methods: {
    // Open file dialog
    openFileDialog() {
      this.$refs.fileInput.click();
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

      try {
        // Validate required fields
        if (!this.form.title || !this.form.content || !this.form.language || 
            !this.form.category || !this.form.type || !this.form.torrentFile) {
          alert('Please fill in all required fields and select a torrent file');
          return;
        }

        // Validate CAPTCHA
        if (this.form.captcha.toUpperCase() !== this.captchaCode) {
          alert('Invalid CAPTCHA code. Please try again.');
          this.refreshCaptcha();
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
        const response = await fetch('/api/torrents', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            // Don't set Content-Type header - let browser set it with boundary for FormData
          }
        });

        if (response.ok) {
          const result = await response.json();
          alert('Torrent uploaded successfully!');
          this.resetForm();
        } else {
          throw new Error('Upload failed');
        }

      } catch (error) {
        console.error('Error submitting post:', error);
        alert('Error uploading torrent. Please try again.');
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
        type: '',
        tags: '',
        description: '',
        torrentFile: null,
        captcha: ''
      };
      this.selectedFilePath = '';
      this.$refs.fileInput.value = '';
      this.refreshCaptcha();
    },

    // Generate CAPTCHA
    generateCaptcha() {
      const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
      this.captchaCode = '';
      for (let i = 0; i < 6; i++) {
        this.captchaCode += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      this.drawCaptcha();
    },

    // Draw CAPTCHA on canvas
    drawCaptcha() {
      this.$nextTick(() => {
        const canvas = this.$refs.captchaCanvas;
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const width = canvas.width;
        const height = canvas.height;

        ctx.clearRect(0, 0, width, height);
        ctx.fillStyle = '#f3f4f6';
        ctx.fillRect(0, 0, width, height);

        // Add noise lines
        for (let i = 0; i < 6; i++) {
          ctx.strokeStyle = `hsl(${Math.random() * 360}, 50%, 70%)`;
          ctx.lineWidth = Math.random() * 2 + 1;
          ctx.beginPath();
          ctx.moveTo(Math.random() * width, Math.random() * height);
          ctx.lineTo(Math.random() * width, Math.random() * height);
          ctx.stroke();
        }

        // Draw CAPTCHA text
        ctx.font = 'bold 16px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';

        for (let i = 0; i < this.captchaCode.length; i++) {
          const char = this.captchaCode[i];
          const x = (width / this.captchaCode.length) * i + (width / this.captchaCode.length) / 2;
          const y = height / 2 + (Math.random() - 0.5) * 8;

          ctx.fillStyle = `hsl(${Math.random() * 360}, 60%, 40%)`;
          ctx.save();
          ctx.translate(x, y);
          ctx.rotate((Math.random() - 0.5) * 0.5);
          ctx.fillText(char, 0, 0);
          ctx.restore();
        }

        // Add noise dots
        for (let i = 0; i < 20; i++) {
          ctx.fillStyle = `hsl(${Math.random() * 360}, 50%, 60%)`;
          ctx.beginPath();
          ctx.arc(
            Math.random() * width,
            Math.random() * height,
            Math.random() * 2 + 1,
            0,
            Math.PI * 2
          );
          ctx.fill();
        }
      });
    },

    // Refresh CAPTCHA
    refreshCaptcha() {
      this.generateCaptcha();
      this.form.captcha = '';
    }
  },

  mounted() {
    this.generateCaptcha();
  }
}
</script>

<style scoped>
.custom-file-input {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>