const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    important: true,
    safelist: [
        'transition', 'ease-out', 'duration-200', 'transform', 'opacity-0', 'scale-95', 'opacity-100', 'scale-100', 'ease-in', 'duration-75',
        'bg-green-500', 'bg-red-500', 'bg-gray-500', 'bg-yellow-400'
    ],
    content: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './config/navigation.php',
    ],
    theme: {
        extend: {
            colors: {
                'primary': colors.red,
                'login-primary': colors.blue,
                'login-secondary': colors.red,
            },
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                '2xs': '0.6rem',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
