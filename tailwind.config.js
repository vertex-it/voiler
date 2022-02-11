const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    important: true,
    content: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './config/navigation.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: colors.red
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
