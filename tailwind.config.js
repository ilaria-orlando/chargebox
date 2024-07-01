/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
        colors: {
          'cream': '#F1FADA',
          'lightsea': '#9AD0C2',
          'darksea': '#2D9596',
          'oceanblue': '#265073',
        }
    },
  },
  plugins: [],
}
