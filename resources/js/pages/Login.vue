<template>
  <div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Sign in to your account
        </h2>
      </div>

      <form @submit.prevent="handleLogin" class="mt-8 space-y-6">
        <div class="rounded-md shadow-sm -space-y-px">
          <!-- Email Input -->
          <div>
            <label for="email" class="sr-only">Email address</label>
            <input id="email" v-model="form.email" type="email" required
              class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              :class="{ 'border-red-500': errors.email }" placeholder="Email address" />
            <div v-if="errors.email" class="text-red-500 text-sm mt-1">
              {{ errors.email[0] }}
            </div>
          </div>

          <!-- Password Input -->
          <div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" v-model="form.password" type="password" required
              class="relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              :class="{ 'border-red-500': errors.password }" placeholder="Password" />
            <div v-if="errors.password" class="text-red-500 text-sm mt-1">
              {{ errors.password[0] }}
            </div>
          </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember" v-model="form.remember" type="checkbox"
              class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
            <label for="remember" class="ml-2 block text-sm text-gray-900">
              Remember me
            </label>
          </div>

          <div class="text-sm">
            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
              Forgot your password?
            </a>
          </div>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit" :disabled="loading"
            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
            <span v-if="loading" class="absolute left-0 inset-y-0 flex items-center pl-3">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
            </span>
            {{ loading ? 'Signing in...' : 'Sign in' }}
          </button>
        </div>

        <!-- Success/Error Messages -->
        <div v-if="message" class="mt-4">
          <div :class="{
            'bg-green-100 border border-green-400 text-green-700': messageType === 'success',
            'bg-red-100 border border-red-400 text-red-700': messageType === 'error'
          }" class="px-4 py-3 rounded">
            {{ message }}
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
  name: 'LoginComponent',

  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: false
      },
      errors: {},
      loading: false,
      message: '',
      messageType: ''
    }
  },

  setup(_, { expose }) {
    const router = useRouter();

    const checkAuth = async () => {
      try {
        const res = await fetch('/me', {
          method: 'GET',
          credentials: 'include'
        });

        if (res.ok) {
          // already logged in → go dashboard
          //router.push('/');
          window.location.href = '/'
        }
      } catch (err) {
        // not logged in → stay on login page
      }
    };

    onMounted(() => {
      checkAuth();
    });

    expose({ checkAuth });
  },

  methods: {
    async handleLogin() {
      this.loading = true;
      this.errors = {};
      this.message = '';

      try {
        const csrfToken = document
          .querySelector('meta[name="csrf-token"]')
          ?.getAttribute('content');

        if (!csrfToken) {
          throw new Error('CSRF token not found. Please refresh the page.');
        }

        const response = await fetch('/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(this.form),
          credentials: 'include'
        });

        const data = await response.json();

        if (response.ok && data.success) {
          this.message = data.message;
          this.messageType = 'success';

          localStorage.setItem('user', JSON.stringify(data.user));

           window.location.href = '/'
        } else {
          if (data.errors) {
            this.errors = data.errors;
          }
          this.message = data.message || 'Login failed.';
          this.messageType = 'error';
        }
      } catch (error) {
        this.message = error.message || 'Network error.';
        this.messageType = 'error';
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>
