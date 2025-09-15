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
        :slides-per-view="5"
        :space-between="20"
        :loop="true"
        :autoplay="{ delay: 2000, disableOnInteraction: false }"
        :speed="2000"
        :breakpoints="{
          320: { slidesPerView: 2 },
          640: { slidesPerView: 3 },
          1024: { slidesPerView: 4 },
          1280: { slidesPerView: 5 }
        }"
        @swiper="onSwiper"
        class="overflow-hidden"
      >
        <SwiperSlide v-for="(category, index) in categories" :key="index">
          <div class="flex-shrink-0 cursor-pointer group">
            <img
              :src="category.image"
              :alt="category.name"
              class="w-36 h-36 sm:w-40 sm:h-40 md:w-48 md:h-48 
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
const isRTL = computed(() => document.dir === "rtl")

const categories = [
  { name: "Music Concerts", image: "/images/1.jpg" },
  { name: "Sports", image: "/images/2.jpg" },
  { name: "Theatre & Plays", image: "/images/3.jpg" },
  { name: "Workshops", image: "/images/4.jpg" },
  { name: "Festivals", image: "/images/5.jpg" },
  { name: "Adssc & Plays", image: "/images/6.jpg" },
  { name: "Tehtr", image: "/images/7.jpg" },
  { name: "Trwy", image: "/images/8.jpg" },
]
</script>
