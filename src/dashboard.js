import Vue from 'vue'
import Widget from './Widget'

Vue.prototype.t = t

document.addEventListener('DOMContentLoaded', function() {
	OCA.Dashboard.register('notestutorial', (el) => {
		const View = Vue.extend(Widget)
		const vm = new View({}).$mount(el)
	})
})
