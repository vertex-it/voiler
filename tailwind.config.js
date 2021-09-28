module.exports = {
    purge: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        container: {
            screens: {
                sm: '600px',
                md: '728px',
                lg: '984px',
                xl: '1240px',
                '2xl': '1496px',
            },
        },
        extend: {
            fontSize: {
                '2xs': '0.6rem',
            },
            screens: {
                '3xl': '1700px',
                '4xl': '1950px',
            },
            listStyleType: {
                'circle': 'circle',
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
