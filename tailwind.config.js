/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Nunito', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif'],
        roboto: ['Roboto', 'sans-serif'],
        montserrat: ['Montserrat', 'sans-serif'],
      },
      screens: {
        'xs': '480px',
        'xxs': '320px',
      },
      fontSize: {
        'xxs': ['0.625rem', '0.875rem'],
      },
      animation: {
        'spin-slow': 'spin 5s linear infinite',
      },
      maxHeight: {
        '128': '32rem',
        '144': '36rem',
      },
    },
  },
  plugins: [],
};