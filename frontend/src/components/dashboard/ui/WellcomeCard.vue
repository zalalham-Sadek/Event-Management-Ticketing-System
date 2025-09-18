<template>

    <div>
      <h2 class=" text-xl  sm:text-3xl  font-semibold mb-6 text-gray-800 dark:text-white">
       Dashboard
      </h2>

      <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 mb-6 shadow-sm">
        <p class="text-lg text-gray-700 dark:text-gray-300">
          👋 Welcome back, <span class="font-semibold text-primary">{{ userName }}</span>!
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
          Here’s a quick overview of your event statistics and activities.
        </p>
      </div>
    </div>
</template>
<script>
export default{
    props:{
        userName:String,
    }
}
</script>