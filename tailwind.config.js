const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'

    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        screens: {
            sm: "576px",
            md: "768px",
            lg: "992px",
            xl: "1202px",
        },
        fontFamily: {
            'helvetica': ['Helvetica', 'sans-serif'],
        },
        extend: {
            colors: {
                'main-gray': '#999999',
                'main-gray-light': '#666666',
                'main-blue-light': '#DDEEFF',
                'main-blue-medium': '#66BBFF',
                'main-purple-medium': '#9999ff',
                'bg-sand': '#F5F5F5',
                'header-purple': '#CCCCFF',
                'header-blue': "#CFEAFF",
                'nav-blue': "#3a8ac7",
                'nav-gray-light': "#dddddd",
                'breadcrumb-blue': "#008CFF",
                'header-purple-hover':'#b2b2e3',
                'btn-bg': '#1ba1e2',
                'btn-border': "#006eaf",
                'btn-green': '#60a917',
                'btn-border-green': '#2d7600',
                'btn-green-hover': '#72c025',

            },
            fontSize: {
                'xm': '0.813rem',
                '3.5xl': '2.75rem',
                '4.5xl': '2.5rem',
                '7.5xl': '5.188rem',
                'small': '0.938rem',
                'medium': '1.375rem',
                'smaller': '0.563rem',
                '40': '2.5rem',
                '5xl': '3.563rem',
                's1': '12px',

            },
            boxShadow: {
                'md1': '0px 0px 5px #3a8ac7',
                'md2': '0px 0px 2px 14px #000',
            },
            spacing: {
                '17': '4.188rem',
                '78': '4.875rem',
                '19': '4.8rem;',
                '85': '20rem',
                '120': '25rem',
                '130': '30rem',
                '150': '31.25rem',
                '160': '35rem',
            },
            height: {
                '0.5': '0.125rem',
            },
            width: {
                '0.5': '0.125rem',
                '150': '36rem',
                '98': '27rem',
                '100': '30rem',
                'user':'60px',
            },
            maxWidth:{
                '10': "10rem",
                '15': "15rem",
            },
            letterSpacing: {
                'very-wide': '0.2em',
            },
            borderWidth: {
                '3': '3px',
                '5': '5px',
            },
            minHeight: {
                '12': '3rem',
                '49': '12.5rem',
                '28': '6.25rem',
            },
            zIndex: {
                '-1': '-1',
            },


        }
    },
    borderColor: theme => ({

        ...theme('colors'),
        DEFAULT: theme('colors.gray.300', 'currentColor'),

        'primary': '#999999',

        'secondary': '#999999',

        'danger': '#e3342f',
    }),

    variants: {
        extend: {
            scale: ['active', 'group-hover'],
        }
    },
    plugins: [
        require('@tailwindcss/line-clamp'),
    ],
}

