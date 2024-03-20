/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        'primary': {
          100: '#E2E2D5',
          200: '#888883',
          300: '#4D4D4D',
          400: '#272727',
        },
        'juan': {
          100: '#E2E2D5',
          200: '#888883',
          300: '#4D4D4D',
          400: '#272727',
        },
      },
      fontFamily: {
        'body': ['Nunito']
      }
    },
  },
  plugins: [],
}