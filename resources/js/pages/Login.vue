
<template>
  <AppLayout> 
     <div class="w-full pt-6 bg-gradient-to-r from-gray-35 to-gray-450">
    <div class=" w-full bg-white shadow-lg rounded-lg p-8   ">
      <!-- Title -->
      <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Login</h2>

      <!-- Form -->
      <form @submit.prevent="login">
        <!-- Email -->
        <div class="mb-4">
          <label class="block text-gray-700 mb-1" for="email">Email</label>
          <input
            id="email"
            type="email"
            v-model="email"
            placeholder="Enter your email"
            class="w-full px-3 py-2 text-black border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label class="block text-gray-700 text-black mb-1" for="password">Password</label>
          <input
            id="password"
            type="password"
            v-model="password"
            placeholder="Enter your password"
            class="w-full px-3 py-2  text-black border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>

        <!-- Submit -->
        <button
          type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
        >
          Login
        </button>
      </form>

      <!-- Message -->
      <p v-if="message" :class="messageClass" class="mt-4 text-center">
        {{ message }}
      </p>
    </div>
  </div>
    
  </AppLayout>
   
</template>



<script>
import AppLayout from './../layouts/AppLayout.vue'
export default {
    components: {
    AppLayout
  },
  data() {
    return {
      email: "",
      password: "",
      message: "",
      messageClass: ""
    };
  },
  methods: {
    async login() {
      // Example static check — replace with API call
      if (this.email === "test@example.com" && this.password === "123456") {
        this.message = "✅ Login successful!";
        this.messageClass = "text-green-600";
      } else {
        this.message = "❌ Invalid email or password.";
        this.messageClass = "text-red-600";
      }
    }
  }
};
</script>

