import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify);

export default new Vuetify({
	theme: {
		dark : true,
		themes: {
			dark: {
				'primary': '#4141CF',
				'secondary': '#27282E',
				'background': '#232429',
				'background-x': '#2C313B',
				'opposite': '#FFFFFF',
			},
		},
	}
})