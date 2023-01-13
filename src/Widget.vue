<template>
	<NcDashboardWidget :items="items"
		:empty-content-message="t('notestutorial', 'No notes created yet')"
		empty-content-icon="icon-rename" />
</template>

<script>
import { NcDashboardWidget } from '@nextcloud/vue'
import { generateUrl } from '@nextcloud/router'
import axios from '@nextcloud/axios'

export default {
	name: 'Widget',
	components: {
		NcDashboardWidget,
	},
	data() {
		return {
			notes: [],
		}
	},
	computed: {
		items() {
			return this.notes.map((note) => {
				return {
					id: note.id,
					mainText: note.title,
					subText: note.content,
					targetUrl: generateUrl('/apps/notestutorial/' + note.id),
				}
			})
		},
	},
	async mounted() {
		const response = await axios.get(generateUrl('/apps/notestutorial/notes'))
		this.notes = response.data
	},
}
</script>
