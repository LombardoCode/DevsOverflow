module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
			ringWidth: {
        '1': '1px',
      }
		},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
