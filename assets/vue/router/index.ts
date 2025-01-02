import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import HomePage from '@/views/HomePage.vue'
import AuthPage from '@/views/AuthPage.vue'
import FeedbackSubmissionPage from '@/views/FeedbackSubmissionPage.vue'
import FeedbackDetailsPage from '@/views/FeedbackDetailsPage.vue'
import RoadmapPage from '@/views/RoadmapPage.vue'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomePage
    },
    {
      path: '/login',
      name: 'login',
      component: AuthPage
    },
    {
      path: '/feedback/new',
      name: 'new feedback',
      component: FeedbackSubmissionPage
    },
    {
      path: '/feedback/:id',
      name: 'feedback',
      component: FeedbackDetailsPage,
      props: true
    },
    {
      path: '/roadmap',
      name: 'roadmap',
      component: RoadmapPage
    }
  ]
})

router.beforeEach(to => {
  const authStore = useAuthStore()

  if (!authStore.isLoggedIn && to.name !== 'login') {
    return '/login'
  }

  if (authStore.isLoggedIn && to.name === 'login') {
    return false
  }
})
