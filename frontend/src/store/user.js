import { defineStore } from 'pinia'
import api from '@/services/api'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,            // object: { id, name, email, role }
    isAuthenticated: false,
  }),

  getters: {
    userRole: (state) => state.user?.role || 'Attendee',
    isAdmin: (state) => state.user?.role === 'Admin',
    isUser: (state) => state.user?.role === 'Organizer',
    // isAuthenticated : (state) => !!state.user
  },

  actions: {
    login(userData) {
      this.user = userData
      this.isAuthenticated = true
      localStorage.setItem('user', JSON.stringify(userData))
    },

    logout() {
      this.user = null
      this.isAuthenticated = false
      localStorage.removeItem('user')
      localStorage.removeItem('api_token')
    },

    loadUserFromStorage() {
      const savedUser = localStorage.getItem('user')
      const savedToken = localStorage.getItem('api_token')
      
      if (savedUser && savedToken) {
        this.user = JSON.parse(savedUser)
        this.isAuthenticated = true
      } else {
        // Clear any partial data if token is missing
        this.logout()
      }
    },

    async fetchCurrentUser() {
      try {
        const response = await api.get('/user')
        this.login(response.data) // update store
      } catch (error) {
        this.logout() // clear store if not authenticated
      }
    }
  }
})
