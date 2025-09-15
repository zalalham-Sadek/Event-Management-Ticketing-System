<template>
  <section class="py-12 my-5 px-6 bg-[var(--color-bg)]">
    <div class="max-w-6xl mx-auto">
      <!-- Section Header -->
      <div class="flex items-center justify-between mb-6">
        <div class="space-y-3 my-3">
          <span class="text-sm px-5 py-1  text-blue-600 font-semibold uppercase bg-[#f7f9fd] dark:bg-[#1f2937]">{{ $t('Popular Location') }}</span>
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-3">
            {{ $t('Explore By Cities') }}
          </h2>
        </div>
        <!-- Navigation buttons -->
        <div class="flex space-x-2">
          <button
            class="w-8 h-8 flex items-center justify-center rounded-full border border-[var(--color-primary)] text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-[var(--color-bg)]"
            @click="swiper.slideNext()"
          >
            <span>&lt;</span>
          </button>
          <button
            class="w-8 h-8 flex items-center justify-center rounded-full border border-[var(--color-primary)] text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-[var(--color-bg)]"
            @click="swiper.slidePrev()"
          >
            <span>&gt;</span>
          </button>
        </div>
      </div>

      <!-- Swiper -->
      <Swiper
        :modules="[Autoplay]"
        :slides-per-view="4"
        :space-between="20"
        :loop="true"
        :autoplay="{ delay: 2500, disableOnInteraction: false }"
        :speed="3000"
        :breakpoints="{
          320: { slidesPerView: 1 },
          640: { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
          1280: { slidesPerView: 4 }
        }"
        @swiper="onSwiper"
        class="overflow-hidden"
      >
        <SwiperSlide v-for="(city, index) in cities" :key="index">
          <div class="relative rounded-xl overflow-hidden shadow-md group">
            <img
              :src="city.image"
              :alt="city.name"
              class="w-full h-60 object-cover  transition-transform duration-1000 ease-in-out group-hover:scale-110"
            />
            <!-- Overlay with softer opacity -->
            <div
              class="absolute inset-0 bg-black bg-opacity-30  flex flex-col items-center justify-center opacity-0 group-hover:opacity-80 transition-opacity duration-1000 ease-in-out text-white"
            >
              <h3 class="text-lg font-bold">{{ city.name }}</h3>
              <p class="text-sm">{{ city.events }} Events</p>
            </div>
          </div>
        </SwiperSlide>
      </Swiper>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue"
import { Swiper, SwiperSlide } from "swiper/vue"
import { Autoplay } from "swiper/modules"
import "swiper/css"

const swiper = ref(null)
const onSwiper = (s) => { swiper.value = s }

const cities = [
  { name: "Chicago", image: "https://picsum.photos/id/1011/500/400", events: 12 },
  { name: "New York", image: "https://picsum.photos/id/1015/500/400", events: 20 },
  { name: "Dubai", image: "https://picsum.photos/id/1025/500/400", events: 8 },
  { name: "Rome", image: "https://picsum.photos/id/1041/500/400", events: 15 },
  { name: "Paris", image: "https://picsum.photos/id/1069/500/400", events: 25 },
  { name: "London", image: "https://picsum.photos/id/1070/500/400", events: 18 },
  { name: "Tokyo", image: "https://picsum.photos/id/1084/500/400", events: 22 },
]
</script>
