<template>
    <section class="relative min-h-screen flex flex-col justify-center overflow-hidden bg-gradient-hero hero-glow">
        
        <div class="container mx-auto px-4  relative z-10">
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 animate-fade-in-left">
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight"><span
                            class="text-gradient">{{$t('Locate and celebrate upcoming events.')}}</span> </h1>
                    
        <div class="banner-content__button">

            <BtnDiscover />

</div>

                
                </div>
                <div class="lg:w-1/2 mt-12 lg:mt-0 animate-fade-in-right">
                    <div class="relative max-w-md mx-auto animate-float"><img
                            src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?auto=format&amp;fit=crop&amp;h=800"
                            alt="Trading platform dashboard" class="rounded-xl shadow-2xl border border-white/10">
                        <div
                            class="absolute -right-6 -bottom-6 bg-crypto-purple/20 backdrop-blur-md rounded-lg p-4 border border-crypto-purple/30 shadow-lg">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 bg-green-500/20 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg></div>
                                <div>
                                    <p class="text-xs text-gray-400">24h Change</p>
                                    <p class="text-lg font-bold text-green-500">+12.34%</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="absolute -left-6 -top-6 bg-crypto-purple/20 backdrop-blur-md rounded-lg p-4 border border-crypto-purple/30 shadow-lg">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="h-10 w-10 bg-crypto-purple/20 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-crypto-purple"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg></div>
                                <div>
                                    <p class="text-xs text-gray-400">Security Level</p>
                                    <p class="text-lg font-bold text-white">Enterprise</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<EventCat />
<EventByCity/>
<FeatureEventSection/>
<HowWork/>
<Soon/>
<FeatureOrganizers/>
<TestimonialsSection/>
<StatisticsSection/>

</template>

<script setup>
import BtnDiscover from '@/components/BtnDiscover.vue';
import EventCat from '@/components/EventCat.vue';
import EventByCity from '@/components/EventByCity.vue';
import FeatureEventSection from '@/components/FeatureEventSection.vue';
import StatisticsSection from '@/components/StatisticsSection.vue';
import HowWork from '@/components/HowWork.vue';
import Soon from '@/components/Soon.vue';
import FeatureOrganizers from '@/components/FeatureOrganizers.vue';
import TestimonialsSection from '@/components/TestimonialsSection.vue';
import Footer from '@/components/Footer.vue';

</script>