<template>
    <nav class="mt-4 space-y-5 text-white px-8 py-4">
        <ItemList label="Dashboard" :sidebarCollapsed="sidebarCollapsed" href="/">
            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2M5 19V5h6v14zm14 0h-6v-7h6zm0-9h-6V5h6z"/></svg>
            </span>
            <!-- <span v-if="!sidebarCollapsed" class="text-[18px] ">Dashboard</span> -->
        </ItemList>
        <ItemList label="Events" :sidebarCollapsed="sidebarCollapsed" href="/events">
            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M14 14H7v2h7m5 3H5V8h14m0-5h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m-2 7H7v2h10z"/></svg>
            </span>
            <!-- <span v-if="!sidebarCollapsed" class="text-[18px] ">Dashboard</span> -->
        </ItemList>
        <ItemList label="Tickets" :sidebarCollapsed="sidebarCollapsed" href="/events/tickets">
            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9 5a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c2.67 0 8 1.34 8 4v2H1v-2c0-2.66 5.33-4 8-4m7.76-9.64c2.02 2.2 2.02 5.25 0 7.27l-1.68-1.69c.84-1.18.84-2.71 0-3.89zM20.07 2c3.93 4.05 3.9 10.11 0 14l-1.63-1.63c2.77-3.18 2.77-7.72 0-10.74z"/></svg>
            </span>
            <!-- <span v-if="!sidebarCollapsed" class="text-[18px] ">Dashboard</span> -->
        </ItemList>

        <!-- Users - Only visible to admin -->
        <ItemList v-if="userStore.isAdmin" label="Users" :sidebarCollapsed="sidebarCollapsed" href="/users">
            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13.07 10.41a5 5 0 0 0 0-5.82A3.4 3.4 0 0 1 15 4a3.5 3.5 0 0 1 0 7a3.4 3.4 0 0 1-1.93-.59M5.5 7.5A3.5 3.5 0 1 1 9 11a3.5 3.5 0 0 1-3.5-3.5m2 0A1.5 1.5 0 1 0 9 6a1.5 1.5 0 0 0-1.5 1.5M16 17v2H2v-2s0-4 7-4s7 4 7 4m-2 0c-.14-.78-1.33-2-5-2s-4.93 1.31-5 2m11.95-4A5.32 5.32 0 0 1 18 17v2h4v-2s0-3.63-6.06-4Z"/></svg>
            </span>
        </ItemList>

    </nav>
</template>


<script setup>
import ItemList from './ItemList.vue';
import { useUserStore } from '@/store/user';

const userStore = useUserStore();

defineProps({
    sidebarCollapsed: Boolean,
});
</script>