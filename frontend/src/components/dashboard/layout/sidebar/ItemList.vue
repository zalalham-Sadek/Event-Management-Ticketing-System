<template>
          <router-link :to="href" class="flex items-center justify-start gap-3 text-[var(--color-text)]">
            <slot></slot>
            <span v-if="!sidebarCollapsed" class="text-[18px] ">{{label}}</span></router-link>
</template>

<script>
export default{
    props :{
        sidebarCollapsed:Boolean,
        label:String,
        href:String
    }
}
</script>