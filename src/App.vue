<template>
	<div id="content" class="app-notestutorial">
		<app-navigation>
			<app-navigation-new v-if="!loading" :text="t('notestutorial', 'New note')" :disabled="false"
				button-id="new-notestutorial-button" button-class="icon-add" @click="newNote" />
			<ul>
				<app-navigation-item v-for="note in notes" :key="note.id" :item="noteEntry(note)" />
			</ul>
		</app-navigation>
		<app-content>
			<div v-if="currentNote">
				<input ref="title" v-model="currentNote.title" type="text"
					:disabled="updating">
				<textarea ref="content" v-model="currentNote.content" :disabled="updating" />
				<input type="button" class="primary" :value="t('notestutorial', 'Save')"
					:disabled="updating || !savePossible" @click="saveNote">
			</div>
			<div v-else id="emptycontent">
				<div class="icon-file" />
				<h2>{{ t('notestutorial', 'Create a note to get started') }}</h2>
			</div>
		</app-content>
	</div>
</template>

<script>
import {
	AppContent,
	AppNavigation,
	AppNavigationItem,
	AppNavigationNew
} from 'nextcloud-vue'

import axios from 'nextcloud-axios'

export default {
	name: 'App',
	components: {
		AppContent,
		AppNavigation,
		AppNavigationItem,
		AppNavigationNew
	},
	data: function() {
		return {
			notes: [],
			currentNoteId: null,
			updating: false,
			loading: true
		}
	},
	computed: {
		/**
		 * Return the currently selected note object
		 */
		currentNote() {
			if (this.currentNoteId === null) {
				return null
			}
			return this.notes.find((note) => note.id === this.currentNoteId)
		},
		/**
		 * Return the item object for the sidebar entry of a note
		 */
		noteEntry() {
			return (note) => {
				return {
					text: note.title,
					action: () => this.openNote(note),
					classes: this.currentNoteId === note.id ? 'active' : '',
					utils: {
						actions: [
							{
								icon: note.id === -1 ? 'icon-close' : 'icon-delete',
								text: note.id === -1 ? t('settings', 'Cancel note creation') : t('settings', 'Delete note'),
								action: () => {
									if (note.id === -1) {
										this.cancelNewNote(note)
									} else {
										this.deleteNote(note)
									}
								}
							}
						]
					}
				}
			}
		},
		/**
		 * Returns true if a note is selected and its title is not empty
		 */
		savePossible() {
			return this.currentNote && this.currentNote.title !== ''
		}
	},
	/**
	 * Fetch list of notes when the component is loaded
	 */
	mounted() {
		axios.get(OC.generateUrl('/apps/notestutorial/notes')).then((response) => {
			this.loading = false
			this.notes = response.data
		})
	},
	methods: {
		/**
		 * Create a new note and focus the note content field automatically
		 */
		openNote(note) {
			if (this.updating) {
				return
			}
			this.currentNoteId = note.id
			this.$nextTick(() => {
				this.$refs.content.focus()
			})
		},
		/**
		 * Action tiggered when clicking the save button
		 * create a new note or save
		 */
		saveNote() {
			if (this.currentNoteId === -1) {
				this.createNote(this.currentNote)
			} else {
				this.updateNote(this.currentNote)
			}
		},
		/**
		 * Create a new note and focus the note content field automatically
		 * The note is not yet saved, therefore an id of -1 is used until it
		 * has been persisted in the backend
		 */
		newNote() {
			if (this.currentNoteId !== -1) {
				this.currentNoteId = -1
				this.notes.push({
					id: -1,
					title: '',
					content: ''
				})
				this.$nextTick(() => {
					this.$refs.title.focus()
				})
			}
		},
		/**
		 * Abort creating a new note
		 */
		cancelNewNote() {
			this.notes.splice(this.notes.findIndex((note) => note.id === -1), 1)
			this.currentNoteId = null
		},
		/**
		 * Create a new note by sending the information to the server
		 */
		createNote(note) {
			this.updating = true
			axios.post(OC.generateUrl(`/apps/notestutorial/notes`), note).then((response) => {
				const index = this.notes.findIndex((match) => match.id === this.currentNoteId)
				this.$set(this.notes, index, response.data)
				this.currentNoteId = response.data.id
				this.updating = false
			})
		},
		/**
		 * Update an existing note on the server
		 */
		updateNote(note) {
			this.updating = true
			axios.put(OC.generateUrl(`/apps/notestutorial/notes/${note.id}`), note).then((response) => {
				this.updating = false
			})
		},
		/**
		 * Delete a note, remove it from the frontend and show a hint
		 */
		deleteNote(note) {
			axios.delete(OC.generateUrl(`/apps/notestutorial/notes/${note.id}`)).then((response) => {
				this.notes.splice(this.notes.indexOf(note), 1)
				if (this.currentNoteId === note.id) {
					this.currentNoteId = null
				}
				window.OCP.Toast.success('Note deleted')
			})
		}
	}
}
</script>
<style>
	#app-content > div {
		width: 100%;
		height: 100%;
		padding: 20px;
		display: flex;
		flex-direction: column;
		flex-grow: 1;
	}
	input[type="text"] {
		width: 100%;
	}
	textarea {
		flex-grow: 1;
		width: 100%;
	}
</style>
