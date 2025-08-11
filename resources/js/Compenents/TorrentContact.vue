<template>
  <div class="max-w-full  mx-auto bg-gray-100 border border-gray-300 shadow-md">
    <!-- Header -->
    <div class=" bg-gray-300 px-5 ">
      <h2 class="text-red-700 font-bold pt-4">Contact 1331x</h2>
    </div>

    <form class=" p-6 space-y-4 text-black">
      <!-- Regarding -->
      <div>
        <label class="block font-semibold mb-1">Regarding</label>
        <select
          v-model="regarding"
          class="w-full border border-gray-300 rounded px-3 py-2"
        >
          <option value="General info">General info</option>
          <option value="Report abuse">Report abuse</option>
          <option value="Technical issue">Technical issue</option>
        </select>
      </div>

      <!-- Your Name -->
      <div>
        <label class="block font-semibold mb-1">Your Name:</label>
        <input
          v-model="name"
          type="text"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
      </div>

      <!-- Your Email -->
      <div>
        <label class="block font-semibold mb-1">Your E-Mail:</label>
        <input
          v-model="email"
          type="email"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
      </div>

      <!-- Message -->
      <div>
        <label class="block font-semibold mb-1">Message:</label>
        <textarea
          v-model="message"
          rows="4"
          placeholder="Enter your Message here."
          class="w-full border border-gray-300 rounded px-3 py-2"
        ></textarea>
      </div>

      <!-- Captcha -->
      <div>
        <label class="block font-semibold mb-1">Captcha:</label>
        <div class="flex items-center space-x-2">
          <img src="" alt="captcha" class="h-10" />
          <input
            v-model="captcha"
            type="text"
            class="flex-1 border border-gray-300 rounded px-3 py-2"
          />
        </div>
      </div>

      <!-- Submit -->
      <div>
        <button
          type="submit"
          class="bg-green-600 text-white font-bold px-4 py-2 rounded hover:bg-green-700"
        >
          SEND MESSAGE
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const regarding = ref('General info')
const name = ref('')
const email = ref('')
const message = ref('')
const captcha = ref('')
</script>
