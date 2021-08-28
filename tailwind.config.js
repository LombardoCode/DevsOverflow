module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
		backgroundColor: theme => ({
			...theme('colors'),
			'azul-100': '#d5e0ed',
		}),
    extend: {
			ringWidth: {
        '1': '1px',
      },
			width: {
				'contenedor-notificaciones': '30rem'
			}
		},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
