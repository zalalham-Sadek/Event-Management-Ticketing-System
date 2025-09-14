/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx,vue}"],
  darkMode: "class", // enable dark mode using the 'dark' class
  theme: {
    extend: {
      fontFamily: {
        cairo: ['"Cairo"', "sans-serif"],
      },
      colors: {
        primary: "#ff6700",
        light: "#ebebeb",
        silver: "#c0c0c0",
        blue: "#3a6ea5",
        darkblue: "#004e98",
        black: "#000000",
        white: "#ffffff",
      },
      animation: {
        "spin-slow": "spin 2s linear infinite",
        "spin-reverse-slow": "spin-reverse 2s linear infinite",
      },
      keyframes: {
        "spin-reverse": {
          to: { transform: "rotate(-360deg)" },
        },
      },
    },
  },
  plugins: [],
};
