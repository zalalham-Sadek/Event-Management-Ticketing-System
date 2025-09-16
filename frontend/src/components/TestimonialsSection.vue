<template>
    <section class="py-12 my-5 px-6 bg-[#f7f9fd] dark:bg-[#1f2937]">
        <div class="max-w-7xl mx-auto">
        <!-- ✅ Reusable Header -->
        <SectionHeader
            title="What Our Attendees Say"
            subtitle="testimonials"
            @prev="swiper.slidePrev()"
            @next="swiper.slideNext()"
        />
    
        <!-- Swiper -->
        <Swiper
            :modules="[Autoplay]"
            :slides-per-view="3"
            :space-between="20"
            :loop="true"
            :autoplay="{ delay: 3000, disableOnInteraction: false }"
            :speed="2000"
            :breakpoints="{
            320: { slidesPerView: 1 },
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
            }"
            @swiper="onSwiper"
            class="overflow-hidden"
        >
            <SwiperSlide v-for="(testimonial, index) in testimonials" :key="index">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 hover:shadow-lg transition-all duration-300 relative border border-gray-100 dark:border-gray-700 group">
                <!-- Quote Icon with FontAwesome -->
                <div class="absolute top-4 ltr:right-4 rtl:left-4 text-gray-200 dark:text-gray-600 text-5xl font-light group-hover:text-blue-100 transition-colors duration-300">
                    <i class="fas fa-quote-right"></i>
                </div>
                
                <!-- Header with Profile -->
                <div class="flex items-center gap-4 mb-5">
                    <div class="relative">
                        <img
                            :src="testimonial.avatar"
                            :alt="testimonial.name"
                            class="w-14 h-14 rounded-full object-cover border-2 border-gray-100 dark:border-gray-600 group-hover:border-blue-200 transition-colors duration-300"
                        />
                        <!-- Online Status Indicator -->
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white dark:border-gray-800"></div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">{{ testimonial.name }}</h3>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-briefcase text-xs text-gray-400"></i>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ testimonial.role }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Stars with FontAwesome -->
                <div class="flex gap-1 mb-5">
                    <i v-for="star in 5" :key="star" class="fas fa-star text-yellow-400 text-sm"></i>
                </div>
                
                <!-- Testimonial Text -->
                <div class="relative">
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-300">{{ testimonial.text }}</p>
                    
                    <!-- Decorative line -->
                    <div class="absolute -left-6 top-0 w-1 h-full bg-gradient-to-b from-blue-400 to-purple-400 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                
                <!-- Bottom accent -->
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ testimonial.date }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-thumbs-up text-green-500 text-xs"></i>
                            <span class="text-xs text-gray-500">{{ testimonial.likes }}</span>
                        </div>
                    </div>
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
import SectionHeader from "./SectionHeader.vue" // ✅ import

// FontAwesome 7 CSS - Add this to your main.js or index.html
// <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

const swiper = ref(null)
const onSwiper = (s) => {
  swiper.value = s
}

const testimonials = [
  {
    name: "Devon Lane",
    role: "Organizer",
    avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face",
    text: "As an event organizer, this platform has been a game-changer for selling tickets. The interface is user-friendly, and the support team is incredibly helpful.",
    date: "2 days ago",
    likes: "24"
  },
  {
    name: "Sarah Johnson",
    role: "Event Manager",
    avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop&crop=face",
    text: "The analytics and reporting features have helped us understand our audience better. Ticket sales have increased by 40% since we started using this platform.",
    date: "1 week ago",
    likes: "18"
  },
  {
    name: "Michael Chen",
    role: "Festival Director",
    avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face",
    text: "Outstanding customer support and seamless integration with our existing systems. The mobile app makes it easy for attendees to manage their tickets.",
    date: "3 days ago",
    likes: "31"
  },
  {
    name: "Emily Rodriguez",
    role: "Conference Coordinator",
    avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face",
    text: "The platform's flexibility allows us to create unique experiences for different types of events. Highly recommended for any event professional.",
    date: "5 days ago",
    likes: "22"
  },
  {
    name: "David Thompson",
    role: "Marketing Director",
    avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=face",
    text: "The marketing tools and social media integration have been invaluable. We've seen a significant boost in event attendance and engagement.",
    date: "1 week ago",
    likes: "27"
  }
]






</script>