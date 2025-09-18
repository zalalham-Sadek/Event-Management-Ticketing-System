    <template>
        <!-- <div :class="{ dark: isDarkMode }"> -->
            <button @click="toggleDarkMode">
                <span class="text-xl " v-if="isDarkMode"><svg class="text-secondary-text" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24">
                        <g fill="currentColor" fill-opacity="0">
                            <path
                                d="M15.22 6.03l2.53 -1.94l-3.19 -0.09l-1.06 -3l-1.06 3l-3.19 0.09l2.53 1.94l-0.91 3.06l2.63 -1.81l2.63 1.81l-0.91 -3.06Z">
                                <animate fill="freeze" attributeName="fill-opacity" begin="0.7s" dur="0.4s"
                                    values="0;1" />
                            </path>
                            <path
                                d="M19.61 12.25l1.64 -1.25l-2.06 -0.05l-0.69 -1.95l-0.69 1.95l-2.06 0.05l1.64 1.25l-0.59 1.98l1.7 -1.17l1.7 1.17l-0.59 -1.98Z">
                                <animate fill="freeze" attributeName="fill-opacity" begin="1.1s" dur="0.4s"
                                    values="0;1" />
                            </path>
                        </g>
                        <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="56"
                            stroke-dashoffset="56" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 6c0 6.08 4.92 11 11 11c0.53 0 1.05 -0.04 1.56 -0.11c-1.61 2.47 -4.39 4.11 -7.56 4.11c-4.97 0 -9 -4.03 -9 -9c0 -3.17 1.64 -5.95 4.11 -7.56c-0.07 0.51 -0.11 1.03 -0.11 1.56Z">
                            <animate fill="freeze" attributeName="fill-opacity" begin="1.5s" dur="0.5s" values="0;1" />
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="56;0" />
                        </path>
                    </svg>
                </span>

                <span v-else class="text-xl ">
                    <svg class="text-secondary-text" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <path stroke-dasharray="2" stroke-dashoffset="2" d="M12 19v1M19 12h1M12 5v-1M5 12h-1">
                                <animate fill="freeze" attributeName="d" begin="1.2s" dur="0.2s"
                                    values="M12 19v1M19 12h1M12 5v-1M5 12h-1;M12 21v1M21 12h1M12 3v-1M3 12h-1" />
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.2s" dur="0.2s"
                                    values="2;0" />
                            </path>
                            <path stroke-dasharray="2" stroke-dashoffset="2"
                                d="M17 17l0.5 0.5M17 7l0.5 -0.5M7 7l-0.5 -0.5M7 17l-0.5 0.5">
                                <animate fill="freeze" attributeName="d" begin="1.4s" dur="0.2s"
                                    values="M17 17l0.5 0.5M17 7l0.5 -0.5M7 7l-0.5 -0.5M7 17l-0.5 0.5;M18.5 18.5l0.5 0.5M18.5 5.5l0.5 -0.5M5.5 5.5l-0.5 -0.5M5.5 18.5l-0.5 0.5" />
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.4s" dur="0.2s"
                                    values="2;0" />
                            </path>
                            <animateTransform attributeName="transform" dur="30s" repeatCount="indefinite" type="rotate"
                                values="0 12 12;360 12 12" />
                        </g>
                        <g fill="currentColor">
                            <path
                                d="M15.22 6.03L17.75 4.09L14.56 4L13.5 1L12.44 4L9.25 4.09L11.78 6.03L10.87 9.09L13.5 7.28L16.13 9.09L15.22 6.03Z">
                                <animate fill="freeze" attributeName="fill-opacity" dur="0.4s" values="1;0" />
                            </path>
                            <path
                                d="M19.61 12.25L21.25 11L19.19 10.95L18.5 9L17.81 10.95L15.75 11L17.39 12.25L16.8 14.23L18.5 13.06L20.2 14.23L19.61 12.25Z">
                                <animate fill="freeze" attributeName="fill-opacity" begin="0.2s" dur="0.4s"
                                    values="1;0" />
                            </path>
                        </g>
                        <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 6 C7 12.08 11.92 17 18 17 C18.53 17 19.05 16.96 19.56 16.89 C17.95 19.36 15.17 21 12 21 C7.03 21 3 16.97 3 12 C3 8.83 4.64 6.05 7.11 4.44 C7.04 4.95 7 5.47 7 6 Z">
                            <set fill="freeze" attributeName="opacity" begin="0.6s" to="0" />
                        </path>
                        <mask id="lineMdMoonFilledToSunnyFilledLoopTransition0">
                            <circle cx="12" cy="12" r="12" fill="#fff" />
                            <circle cx="18" cy="6" r="12" fill="#fff">
                                <animate fill="freeze" attributeName="cx" begin="0.6s" dur="0.4s" values="18;22" />
                                <animate fill="freeze" attributeName="cy" begin="0.6s" dur="0.4s" values="6;2" />
                                <animate fill="freeze" attributeName="r" begin="0.6s" dur="0.4s" values="12;3" />
                            </circle>
                            <circle cx="18" cy="6" r="10">
                                <animate fill="freeze" attributeName="cx" begin="0.6s" dur="0.4s" values="18;22" />
                                <animate fill="freeze" attributeName="cy" begin="0.6s" dur="0.4s" values="6;2" />
                                <animate fill="freeze" attributeName="r" begin="0.6s" dur="0.4s" values="10;1" />
                            </circle>
                        </mask>
                        <circle cx="12" cy="12" r="10" mask="url(#lineMdMoonFilledToSunnyFilledLoopTransition0)"
                            opacity="0" fill="currentColor">
                            <animate fill="freeze" attributeName="r" begin="0.6s" dur="0.4s" values="10;6" />
                            <set fill="freeze" attributeName="opacity" begin="0.6s" to="1" />
                        </circle>
                    </svg>
                </span>

                <!-- {{ isDarkMode ? 'Switch to Light' : 'Switch to Dark' }} -->
            </button>
        <!-- </div> -->
    </template>

<script>
export default {
    data() {
        return {
            isDarkMode: false
        };
    },
    created() {
        // Check localStorage on load
        const storedMode = localStorage.getItem('darkMode');
        this.isDarkMode = storedMode === 'true';

        // Set the HTML class if needed (for Tailwind's dark mode)
        if (this.isDarkMode) {
            document.documentElement.classList.add('dark');
        }
    },
    methods: {
        toggleDarkMode() {
            this.isDarkMode = !this.isDarkMode;
            localStorage.setItem('darkMode', this.isDarkMode);

            // Add/remove dark class from html
            if (this.isDarkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }
};
</script>
