// tailwind.config.js
module.exports = {
  content: [
    "./*.php", // Asegúrate de que Tailwind procese tus archivos PHP
  ],
  theme: {
    extend: {
      colors: {
        'pumpkin': '#F97316',
        'orange-crayola-1': '#FF6F3C',
        'orange-crayola-2': '#FF8643',
        'sandy-brown': '#FF9C4A',
        'sunglow': '#FFC857',
        'jonquil': '#FACC15',
        'ghost-white': '#F4F4F9',
        'onyx': '#393E46',
        'jet': '#2E2E2E',
        // Modos claro y oscuro
        'bg-light': '#F4F4F9',
        'text-light': '#393E46',
        'bg-dark': '#2E2E2E',
        'text-dark': '#F4F4F9',
      },
      fontFamily: {
        sans: ['Arial', 'sans-serif'],
      },
    },
  },
  darkMode: 'class', // Activa el modo oscuro por clase
  plugins: [],
}


