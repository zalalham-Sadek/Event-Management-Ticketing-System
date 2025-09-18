<template>
    <div class="p-6 rounded-2xl shadow-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center space-x-5">
    <div :class="class" class="">
      <slot></slot>
    </div>
    <div>
      <p class="text-l text-gray-600 dark:text-gray-300 font-semibold ">{{title}}</p>
      <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ total }}</p>
    </div>
  </div>
</template>

<script>
export default {
    props:{
        class:String,
        title:String,
        total:Number
    }
}
</script>