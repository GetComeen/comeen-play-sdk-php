const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
  purge: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
      './app/Domain/**/*.vue',
      './app/Domain/**/*.js',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        fontFamily: {
            sans: ['Inter var', ...defaultTheme.fontFamily.sans],
        },
        colors: {
          primary: {
            '900': '#144800',
            '800': '#1b5f01',
            '700': '#1f7203',
            '600': '#2d8f0b',
            '500': '#239d00',
            '400': '#66c141',
            '300': '#6fc14c',
            '200': '#8dca7d',
            '100': '#ade3ac',
          },
        },
        backgroundColor: theme => ({
            ...theme('colors'),
        })
    },
  },
  plugins: [
      require('@tailwindcss/forms'),
  ],
}
