<template>

    <router-link :to="href"
        class="inline-flex items-center gap-2 px-5 py-1.5 bg-[var(--color-primary)] text-white rounded-xl hover:bg-[var(--color-primary-hover)] dark:outline-1 hover:outline-1 shadow-sm transition">
        <i class="fas fa-plus"></i>
        <span>{{ btnTitle }}</span>
    </router-link>

</template>

<script>
export default {
    props: {
        btnTitle: String,
        href: String
    }
}
</script>