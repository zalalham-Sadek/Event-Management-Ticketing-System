<template>
  <section class="py-10 bg-[#f7f9fd] dark:bg-[#1f2937]">
    <div class="max-w-6xl mx-auto relative">
      <h2 class="text-3xl font-bold mb-6 text-[var(--color-text)] dark:text-[var(--color-accent)]">
        Event Categories
      </h2>

      <!-- Left Arrow -->
      <button
        @click="scrollLeft"
        class="absolute left-2 md:left-0 top-1/2 -translate-y-1/2 bg-[var(--color-primary)] text-white p-3 md:p-4 rounded-full shadow-lg z-10 hover:bg-[var(--color-primary-hover)]"
      >
        &#10094;
      </button>

      <!-- Right Arrow -->
      <button
        @click="scrollRight"
        class="absolute right-2 md:right-0 top-1/2 -translate-y-1/2 bg-[var(--color-primary)] text-white p-3 md:p-4 rounded-full shadow-lg z-10 hover:bg-[var(--color-primary-hover)]"
      >
        &#10095;
      </button>

      <!-- Slider -->
      <div ref="slider" class="overflow-hidden">
        <div class="flex gap-6 animate-smooth-step whitespace-nowrap">
          <div
            v-for="(category, index) in [...categories, ...categories]"
            :key="index"
            class="flex-shrink-0 w-36 sm:w-40 md:w-48 cursor-pointer group"
          >
            <img
              :src="category.image"
              :alt="category.name"
              class="w-36 h-36 sm:w-40 sm:h-40 md:w-48 md:h-48 object-cover rounded-full transition-transform duration-300 group-hover:scale-105 mx-auto"
            />
            <h3 class="mt-2 text-center font-semibold text-[var(--color-text)] dark:text-[var(--color-accent)] text-sm sm:text-base md:text-lg">
              {{ category.name }}
            </h3>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";

const categories = [
  { name: "Music Concerts", image: "/images/music.jpg" },
  { name: "Sports", image: "/images/sports.jpg" },
  { name: "Theatre & Plays", image: "/images/theatre.jpg" },
  { name: "Workshops", image: "/images/workshop.jpg" },
  { name: "Festivals", image: "/images/festival.jpg" },
  { name: "Adssc & Plays", image: "/images/theatre.jpg" },
  { name: "Tehtr", image: "/images/workshop.jpg" },
  { name: "Trwy", image: "/images/festival.jpg" },
];

const slider = ref(null);
const scrollAmount = 264; // Approx width of one card + gap

const scrollLeft = () => {
  slider.value.scrollBy({ left: -scrollAmount, behavior: "smooth" });
};

const scrollRight = () => {
  slider.value.scrollBy({ left: scrollAmount, behavior: "smooth" });
};
</script>

<style scoped>
@layer utilities {
  /* Section background colors */
  .bg-light-section { background-color: #f7f9fd; }
  .dark.bg-dark-section { background-color: #1f2937; } /* Example dark: slate-800 */

  /* Smooth step-by-step scroll */
  @keyframes smooth-step-scroll {
    0%   { transform: translateX(0%); }
    10%  { transform: translateX(-12.5%); }
    20%  { transform: translateX(-12.5%); }
    30%  { transform: translateX(-25%); }
    40%  { transform: translateX(-25%); }
    50%  { transform: translateX(-37.5%); }
    60%  { transform: translateX(-37.5%); }
    70%  { transform: translateX(-50%); }
    80%  { transform: translateX(-50%); }
    90%  { transform: translateX(-62.5%); }
    100% { transform: translateX(-62.5%); }
  }

  .animate-smooth-step {
    animation: smooth-step-scroll 28s linear infinite;
  }
}
</style>
