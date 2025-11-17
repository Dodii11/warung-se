/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        primary: 'var(--color-primary)',
        'primary-dark': 'var(--color-primary-dark)',
        secondary: 'var(--color-secondary)',
        success: 'var(--color-success)',
        warning: 'var(--color-warning)',
        error: 'var(--color-error)',
        gray: {
          50: 'var(--color-gray-50)',
          100: 'var(--color-gray-100)',
          300: 'var(--color-gray-300)',
          600: 'var(--color-gray-600)',
          900: 'var(--color-gray-900)',
        },
        bg: 'var(--color-bg)',
        white: 'var(--color-white)',
      },
      fontFamily: {
        main: ['var(--font-main)', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
