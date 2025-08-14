import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import Category from '../pages/Category.vue'
import Dashboard from '../pages/Dashboard.vue'
import Upload from '../pages/Upload.vue'

const routes = [
  { path: '/', component: Dashboard },
  { path: '/category/:name', component: Category },
  { 
    path: '/upload',
    component: Upload,
    meta: { requiresAuth: true }
  }
]
const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach(async (to, from, next) => {
  if (to.meta.requiresAuth) {
    const res = await fetch('/me', {
      credentials: 'include'
    });
    if (res.ok) {
      next();
    } else {
      next('/login');
    }
  } else {
    next();
  }
});
export default createRouter({
  history: createWebHistory(),
  routes,
})
