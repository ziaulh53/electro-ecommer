/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'theme-color': "#243c5a",
        'theme-light': "#28476d",
      },
    },
  },
  plugins: [],
}

