// src/i18n.js
import { createI18n } from "vue-i18n";
import en from "./locales/en.json";
import ar from "./locales/ar.json";

const messages = { en, ar };

// initial locale from localStorage (fallback to en)
const saved = localStorage.getItem("language") || "en";

export const i18n = createI18n({
  legacy: false,          // Composition API style
  locale: saved,
  fallbackLocale: "en",
  messages,
});
