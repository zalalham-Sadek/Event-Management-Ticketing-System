<template>
    <button @click="toggleCollapse" class="hidden md:block  text-lg   py-1  hover:bg-hover hover:rounded-2xl">
        <span v-if="sidebarCollapsed" class="rounded-full ">
            <!-- Icon for collapsed state -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="text-primary-text">
                <path fill="currentColor"
                    d="m10.537 12l-4.24-4.246q-.141-.14-.154-.341t.153-.367q.16-.16.354-.16t.354.16l4.388 4.389q.131.13.184.267t.053.298t-.053.298t-.184.268l-4.388 4.388q-.14.14-.341.153t-.367-.153q-.16-.16-.16-.354t.16-.354zm6.1 0l-4.24-4.246q-.141-.14-.154-.341t.153-.367q.16-.16.354-.16t.354.16l4.388 4.389q.131.13.184.267t.053.298t-.053.298t-.184.268l-4.388 4.388q-.14.14-.341.153t-.367-.153q-.16-.16-.16-.354t.16-.354z" />
            </svg>
        </span>
        <span v-else>
            <!-- Icon for expanded state -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="text-primary-text">
                <path fill="currentColor"
                    d="M11.25 17.308L5.942 12l5.308-5.308l.708.708L7.364 12l4.594 4.6zm6.1 0L12.042 12l5.308-5.308l.708.708l-4.594 4.6l4.594 4.6z" />
            </svg>
        </span>
    </button>
</template>

<script>
export default {
    props: {
        toggleCollapse: Function,
        sidebarCollapsed: Boolean
    }
}
</script>