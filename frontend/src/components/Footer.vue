<template>  
  <footer class="pt-12 mt-5 px-6 bg-[#242b4e] dark:bg-[#020e1f]">
    <div class="max-w-6xl mx-auto">
      <!-- Main Footer Content -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          
          <!-- EventLab Information Column -->
          <div class="space-y-6">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
              <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-ticket-alt text-white text-2xl"></i>
              </div>
              <div>
                <h3 class="text-lg md:text-xl font-bold text-white">TicMate</h3>
                <p class="text-xs md:text-sm text-blue-200 dark:text-[var(--color-text)]">
                  {{ $t('Event Ticket Booking System') }}
                </p>
              </div>
            </div>
            
            <!-- Description -->
            <p class="text-gray-300 text-sm leading-relaxed">
              {{ $t('EventLab is a global self-service ticketing platform for live experiences that allows anyone to create, share, find and attend events.') }}
            </p>
            
            <!-- Follow Us -->
            <div>
              <h4 class="text-white font-semibold mb-3">{{$t('Follow Us')}}</h4>
              <div class="flex flex-wrap gap-2">
                <a href="#" class="w-7 h-7 rounded-lg ring-1 flex items-center justify-center hover:bg-[var(--color-primary)] transition-colors duration-300">
                  <i class="fab fa-youtube text-sm sm:text-base text-blue-200 dark:text-[var(--color-text)] hover:text-white"></i>
                </a>
                <a href="#" class="w-7 h-7 rounded-lg ring-1 flex items-center justify-center hover:bg-[var(--color-primary)] transition-colors duration-300">
                  <i class="fab fa-instagram text-sm sm:text-base text-blue-200 dark:text-[var(--color-text)] hover:text-white"></i>
                </a>
                <a href="#" class="w-7 h-7 rounded-lg ring-1 flex items-center justify-center hover:bg-[var(--color-primary)] transition-colors duration-300">
                  <i class="fab fa-twitter text-sm sm:text-base text-blue-200 dark:text-[var(--color-text)] hover:text-white"></i>
                </a>
                <a href="#" class="w-7 h-7 rounded-lg ring-1 flex items-center justify-center hover:bg-[var(--color-primary)] transition-colors duration-300">
                  <i class="fab fa-whatsapp text-sm sm:text-base text-blue-200 dark:text-[var(--color-text)] hover:text-white"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Quick Link Column -->
          <div>
            <h4 class="text-white font-semibold mb-4 relative">
              Quick Link
              <span class="absolute bottom-0 start-0 w-8 h-0.5 bg-blue-400"></span>
            </h4>
            <ul class="space-y-2 sm:space-y-3">
              <li><a href="#" class="text-gray-300 hover:text-white transition">{{$t('Home')}}</a></li>
              <li><a href="#" class="text-gray-300 hover:text-white transition">{{$t('About')}}</a></li>
              <li><a href="#" class="text-gray-300 hover:text-white transition">{{$t('Blogs')}}</a></li>
              <li><a href="#" class="text-gray-300 hover:text-white transition">{{$t('Contact')}}</a></li>
            </ul>
          </div>

          <!-- Categories Column -->
          <div>
            <h4 class="text-white font-semibold mb-4 relative">
              Categories
              <span class="absolute bottom-0 start-0 w-8 h-0.5 bg-blue-400"></span>
            </h4>
            <ul class="space-y-2 sm:space-y-3">
              <li><a href="#" class="text-gray-300 hover:text-white transition">Business Conferences</a></li>
              <li><a href="#" class="text-gray-300 hover:text-white transition">Technology Summits</a></li>
              <li><a href="#" class="text-gray-300 hover:text-white transition">Dance Performances</a></li>
              <li><a href="#" class="text-gray-300 hover:text-white transition">Car Shows</a></li>
            </ul>
          </div>

          <!-- Subscribe Column -->
          <div>
            <h4 class="text-white font-semibold mb-4 relative">
              {{$t('Subscribe')}}
              <span class="absolute bottom-0 start-0 w-8 h-0.5 bg-blue-400"></span>
            </h4>
            
            <!-- Email Input -->
            <div class="flex mb-4">
              <input 
                type="email" 
                placeholder="Enter your email"
                class="w-36 sm:w-40 px-3 py-2 bg-gray-800 text-white placeholder-gray-400 
                       rounded-s-lg border border-gray-700 focus:outline-none 
                       focus:border-blue-400 focus:ring-1 focus:ring-blue-400 text-sm sm:text-base"
              />
              <button class="px-4 py-2 bg-blue-400 hover:bg-black/40 dark:bg-[var(--color-text)] text-white  
                             font-medium rounded-e-lg transition">
                {{$t('Subscribe')}}
              </button>
            </div>

            <!-- Description -->
            <p class="text-gray-300 text-xs sm:text-sm leading-relaxed">
              {{$t('Be the first to know about upcoming events, exclusive discounts, and insider tips! Subscribe to our newsletter now and stay connected with us.')}}
            </p>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="border-t border-gray-700 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <!-- Copyright -->
            <div class="text-gray-400 text-xs sm:text-sm text-center sm:text-left">
              {{$t('©2025 TicMate. All Right Reserved.')}}
            </div>
            
            <!-- Links and Scroll Button -->
            <div class="flex items-center gap-4 sm:gap-6">
              <!-- Privacy and Terms Links -->
              <div class="flex gap-3 sm:gap-4">
                <a href="#" class="text-gray-400 hover:text-white text-xs sm:text-sm transition">{{$t('Privacy Policy')}}</a>
                <a href="#" class="text-gray-400 hover:text-white text-xs sm:text-sm transition">{{$t('Terms of Service')}}</a>
              </div>
              
              <!-- Scroll to Top Button -->
             <!-- Scroll to Top Button -->
<button 
  @click="scrollToTop"
  :class="[ 
    'fixed bottom-4 right-4 sm:bottom-6 sm:right-6 w-10 h-10 sm:w-12 sm:h-12 bg-[var(--color-primary)] hover:bg-[var(--color-text)] rounded-full flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl z-50',
    showScrollButton ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none'
  ]"
>
  <i class="fas fa-chevron-up text-white text-base sm:text-lg"></i>
</button>

            </div>
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
