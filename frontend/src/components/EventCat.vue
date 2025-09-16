<template>
  <section class="py-10 bg-[#f7f9fd] dark:bg-[#1f2937]">
    <div class="max-w-6xl mx-auto relative">
      
      <!-- Left Arrow -->
      <button
        @click="isRTL ? swiper.slideNext() : swiper.slidePrev()"
        :class="[
          'absolute top-1/2 -translate-y-1/2 bg-[var(--color-primary)] text-white w-8 h-8 md:w-8 md:h-8 flex items-center justify-center rounded-full shadow-lg z-10 hover:bg-[var(--color-primary-hover)]',
          isRTL ? 'right-2 md:right-0' : 'left-2 md:left-0'
        ]"
      >
        <span>&#10095;</span>
      </button>

      <!-- Right Arrow -->
      <button
        @click="isRTL ? swiper.slidePrev() : swiper.slideNext()"
        :class="[
          'absolute top-1/2 -translate-y-1/2 bg-[var(--color-primary)] text-white w-8 h-8 md:w-8 md:h-8 flex items-center justify-center rounded-full shadow-lg z-10 hover:bg-[var(--color-primary-hover)]',
          isRTL ? 'left-2 md:left-0' : 'right-2 md:right-0'
        ]"
      >
        <span>&#10094;</span>
      </button>

      <!-- Swiper -->
      <Swiper
        :modules="[Autoplay]"
        :slides-per-view="6"
        :space-between="10" 
        :loop="true"
        :autoplay="{ delay: 2000, disableOnInteraction: false }"
        :speed="2000"
        :breakpoints="{
          320: { slidesPerView: 2, spaceBetween: 5 },
          640: { slidesPerView: 3, spaceBetween: 8 },
          1024: { slidesPerView: 5, spaceBetween: 10 },
          1280: { slidesPerView: 6, spaceBetween: 10 }  
        }"
        @swiper="onSwiper"
        class="overflow-hidden"
      >
        <SwiperSlide v-for="(category, index) in categories" :key="index">
          <div class="flex-shrink-0 cursor-pointer group">
            <img
              :src="category.image"
              :alt="category.name"
              class="w-25 h-25 sm:w-25 sm:h-25 md:w-25 md:h-25 
                     object-cover rounded-full 
                     transition-transform duration-300 
                     group-hover:scale-105 mx-auto"
            />
            <h3
              class="mt-2 text-center font-semibold text-[var(--color-text)] dark:text-[var(--color-accent)] text-sm sm:text-base md:text-lg"
            >
              {{ $t(category.name) }}
            </h3>
          </div>
        </SwiperSlide>
      </Swiper>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from "vue"
import { Swiper, SwiperSlide } from "swiper/vue"
import { Autoplay } from "swiper/modules"
import "swiper/css"

const swiper = ref(null)
const onSwiper = (s) => { swiper.value = s }

// Detect RTL mode

const categories = [
  { name: "Music Concerts", image: "/images/events/1.jpg" },
  { name: "Sports", image: "/images/events/2.jpg" },
  { name: "Theatre & Plays", image: "/images/events/3.jpg" },
  { name: "Workshops", image: "/images/events/4.jpg" },
  { name: "Festivals", image: "/images/events/5.jpg" },
  { name: "Adssc & Plays", image: "/images/events/6.jpg" },
  { name: "Tehtr", image: "/images/events/7.jpg" },
  { name: "Trwy", image: "/images/events/8.jpg" },
]
</script>
