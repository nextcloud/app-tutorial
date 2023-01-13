import Vue from 'vue'
import Widget from './Widget.vue'

Vue.prototype.t = t

document.addEventListener('DOMContentLoaded', function() {
	OCA.Dashboard.register('notestutorial', (el) => {
		const View = Vue.extend(Widget);
		(() => new View({}).$mount(el))()
	})
})
