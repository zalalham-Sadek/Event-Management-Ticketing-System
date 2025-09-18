import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,            // object: { id, name, email, role }
    isAuthenticated: false,
  }),

  getters: {
    userRole: (state) => state.user?.role || 'guest',
    isAdmin: (state) => state.user?.role === 'admin',
    isUser: (state) => state.user?.role === 'user',
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
    },

    loadUserFromStorage() {
      const savedUser = localStorage.getItem('user')
      if (savedUser) {
        this.user = JSON.parse(savedUser)
        this.isAuthenticated = true
      }
    }
  }
})
