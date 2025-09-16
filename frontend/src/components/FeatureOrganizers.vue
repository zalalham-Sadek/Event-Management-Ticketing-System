<template>
  <section class="py-8 sm:py-12 md:py-16 px-3 sm:px-4 md:px-6 bg-[var(--color-bg)]">
    <div class="max-w-6xl mx-auto">
      <!-- Section Header -->
      <SectionHeader
        title="Featured Organizers"
        subtitle="Featured"
      />

      <!-- Organizer Cards Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mt-8">
        <OrganizerCard 
          v-for="organizer in organizers"
          :key="organizer.id"
          :name="organizer.name"
          :followers="organizer.followers"
          :avatar-url="organizer.avatarUrl"
          class="transition-transform transform hover:scale-105 duration-300"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import SectionHeader from './SectionHeader.vue';
import OrganizerCard from './OrganizerCard.vue';

const organizers = [
  { id: 1, name: "Creative Events Agency", followers: 6, avatarUrl: "/public/images/events/1.jpg" },
  { id: 2, name: "Tech Conference Pro", followers: 12, avatarUrl: "/public/images/events/2.jpg" },
  { id: 3, name: "Music Festival Hub", followers: 8, avatarUrl: "/public/images/events/3.jpg" },
  { id: 4, name: "Art Gallery Events", followers: 15, avatarUrl: "/public/images/events/4.jpg" },
  { id: 5, name: "Sports Mania", followers: 20, avatarUrl: "/public/images/events/5.jpg" },
  { id: 6, name: "Foodie Events Co.", followers: 9, avatarUrl: "/public/images/events/6.jpg" },
  { id: 7, name: "Business Summit Org", followers: 14, avatarUrl: "/public/images/events/7.jpg" },
  { id: 8, name: "Wellness Retreats", followers: 11, avatarUrl: "/public/images/events/8.jpg" },
];
</script>

<style scoped>
/* Optional: subtle shadow on hover for a nicer effect */
.OrganizerCard:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}
</style>
