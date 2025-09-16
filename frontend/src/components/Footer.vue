<template>
  <footer class="pt-12 my-5 bg-[#242b4e] dark:bg-[#020e1f]">
    <!-- Main Footer Content -->
    <div class="container max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        
        <!-- EventLab Information Column -->
        <div class="space-y-6">
          <!-- Logo -->
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
              <i class="fas fa-ticket-alt text-white text-xl"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">EventLab</h3>
              <p class="text-sm text-blue-200">Event Ticket Booking System</p>
            </div>
          </div>
          
          <!-- Description -->
          <p class="text-gray-300 text-sm leading-relaxed">
            EventLab is a global self-service ticketing platform for live experiences that allows anyone to create, share, find and attend events.
          </p>
          
          <!-- Follow Us -->
          <div>
            <h4 class="text-white font-semibold mb-4">Follow Us</h4>
            <div class="flex space-x-3">
              <a href="#" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-500 transition-colors duration-300">
                <i class="fab fa-youtube text-white"></i>
              </a>
              <a href="#" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-500 transition-colors duration-300">
                <i class="fab fa-instagram text-white"></i>
              </a>
              <a href="#" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-500 transition-colors duration-300">
                <i class="fab fa-twitter text-white"></i>
              </a>
              <a href="#" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-500 transition-colors duration-300">
                <i class="fab fa-whatsapp text-white"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Quick Link Column -->
        <div>
          <h4 class="text-white font-semibold mb-4 relative">
            Quick Link
            <div class="absolute bottom-0 left-0 w-8 h-0.5 bg-blue-400"></div>
          </h4>
          <ul class="space-y-3">
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Home</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">About</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Blogs</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Contact</a></li>
          </ul>
        </div>

        <!-- Categories Column -->
        <div>
          <h4 class="text-white font-semibold mb-4 relative">
            Categories
            <div class="absolute bottom-0 left-0 w-8 h-0.5 bg-blue-400"></div>
          </h4>
          <ul class="space-y-3">
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Business Conferences</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Technology Summits</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Dance Performances</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">Car Shows</a></li>
          </ul>
        </div>

        <!-- Subscribe Column -->
        <div>
          <h4 class="text-white font-semibold mb-4 relative">
            Subscribe
            <div class="absolute bottom-0 left-0 w-8 h-0.5 bg-blue-400"></div>
          </h4>
          
          <!-- Email Input -->
          <div class="flex mb-4">
            <input 
              type="email" 
              placeholder="Enter your email"
              class="flex-1 px-4 py-2 bg-gray-800 text-white placeholder-gray-400 rounded-l-lg border border-gray-700 focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400"
            />
            <button class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-r-lg transition-colors duration-300">
              Subscribe
            </button>
          </div>
          
          <!-- Description -->
          <p class="text-gray-300 text-sm leading-relaxed">
            Be the first to know about upcoming events, exclusive discounts, and insider tips! Subscribe to our newsletter now and stay connected with us.
          </p>
        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-700 mt-10">
      <div class="container max-w-7xl mx-auto px-6 py-6">
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
          <!-- Copyright -->
          <div class="text-gray-400 text-sm">
            ©2025 EventLab. All Right Reserved.
          </div>
          
          <!-- Links and Scroll Button -->
          <div class="flex items-center space-x-6">
            <!-- Privacy and Terms Links -->
            <div class="flex space-x-4">
              <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-300">Privacy Policy</a>
              <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-300">Terms of Service</a>
            </div>
            
            <!-- Scroll to Top Button -->
            <button 
              @click="scrollToTop"
              :class="[
                'fixed bottom-6 right-6 w-12 h-12 bg-blue-500 hover:bg-blue-600 rounded-full flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl z-50',
                showScrollButton ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none'
              ]"
            >
              <i class="fas fa-chevron-up text-white text-lg"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>


<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const showScrollButton = ref(false);

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
};

const handleScroll = () => {
  showScrollButton.value = window.scrollY > 300;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
/* Custom scroll behavior */
html {
  scroll-behavior: smooth;
}
</style>
