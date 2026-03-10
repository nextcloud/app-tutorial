<template>
	<div id="content" class="app-notestutorial">
		<NcAppNavigation>
			<NcAppNavigationNew v-if="!loading"
				:text="t('notestutorial', 'New note')"
				:disabled="false"
				button-id="new-notestutorial-button"
				@click="newNote" />
			<ul>
				<NcAppNavigationItem v-for="note in notes"
					:key="note.id"
					:name="note.title ? note.title : t('notestutorial', 'New note')"
					:class="{active: currentNoteId === note.id}"
					@click="openNote(note)">
					<template #actions>
						<NcActionButton v-if="note.id === -1"
							icon="icon-close"
							@click="cancelNewNote(note)">
							{{ t('notestutorial', 'Cancel note creation') }}
						</NcActionButton>
						<NcActionButton v-else
							icon="icon-delete"
							@click="deleteNote(note)">
							{{ t('notestutorial', 'Delete note') }}
						</NcActionButton>
					</template>
				</NcAppNavigationItem>
			</ul>
		</NcAppNavigation>
		<NcAppContent>
			<div v-if="currentNote">
				<input ref="title"
					v-model="currentNote.title"
					type="text"
					:disabled="updating">
				<textarea ref="content" v-model="currentNote.content" :disabled="updating" />
				<input type="button"
					class="primary"
					:value="t('notestutorial', 'Save')"
					:disabled="updating || !savePossible"
					@click="saveNote">
			</div>
			<div v-else id="emptycontent">
				<div class="icon-file" />
				<h2>{{ t('notestutorial', 'Create a note to get started') }}</h2>
			</div>
		</NcAppContent>
	</div>
</template>

<script setup lang="ts">
import { computed, nextTick, onMounted, ref, useTemplateRef } from 'vue'
import axios from '@nextcloud/axios'
import { t } from '@nextcloud/l10n'
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import {
	NcActionButton,
	NcAppContent,
	NcAppNavigation,
	NcAppNavigationItem,
	NcAppNavigationNew,
} from '@nextcloud/vue'

interface Note {
	id: number
	title: string
	content: string
}

const titleRef = useTemplateRef<HTMLInputElement>('title')
const contentRef = useTemplateRef<HTMLTextAreaElement>('content')

const notes = ref<Note[]>([])
const currentNoteId = ref<number | null>(null)
const updating = ref(false)
const loading = ref(true)

const currentNote = computed(() => {
	if (currentNoteId.value === null) {
		return undefined
	}
	return notes.value.find((note) => note.id === currentNoteId.value)
})

const savePossible = computed(() => {
	return !!currentNote.value && currentNote.value.title !== ''
})

function openNote(note: Note) {
	if (updating.value) {
		return
	}
	currentNoteId.value = note.id
	nextTick(() => {
		contentRef.value?.focus()
	})
}

function saveNote() {
	if (currentNoteId.value === -1) {
		createNote(currentNote.value!)
	} else {
		updateNote(currentNote.value!)
	}
}

function newNote() {
	if (currentNoteId.value !== -1) {
		currentNoteId.value = -1
		notes.value.push({
			id: -1,
			title: '',
			content: '',
		})
		nextTick(() => {
			titleRef.value?.focus()
		})
	}
}

function cancelNewNote() {
	notes.value.splice(notes.value.findIndex((note) => note.id === -1), 1)
	currentNoteId.value = null
}

async function createNote(note: Note) {
	updating.value = true
	try {
		const response = await axios.post<Note>(generateUrl('/apps/notestutorial/notes'), note)
		const index = notes.value.findIndex((match) => match.id === currentNoteId.value)
		notes.value[index] = response.data
		currentNoteId.value = response.data.id
	} catch (e) {
		console.error(e)
		showError(t('notestutorial', 'Could not create the note'))
	}
	updating.value = false
}

async function updateNote(note: Note) {
	updating.value = true
	try {
		await axios.put(generateUrl(`/apps/notestutorial/notes/${note.id}`), note)
	} catch (e) {
		console.error(e)
		showError(t('notestutorial', 'Could not update the note'))
	}
	updating.value = false
}

async function deleteNote(note: Note) {
	try {
		await axios.delete(generateUrl(`/apps/notestutorial/notes/${note.id}`))
		notes.value.splice(notes.value.indexOf(note), 1)
		if (currentNoteId.value === note.id) {
			currentNoteId.value = null
		}
		showSuccess(t('notestutorial', 'Note deleted'))
	} catch (e) {
		console.error(e)
		showError(t('notestutorial', 'Could not delete the note'))
	}
}

onMounted(async () => {
	try {
		const response = await axios.get<Note[]>(generateUrl('/apps/notestutorial/notes'))
		notes.value = response.data
	} catch (e) {
		console.error(e)
		showError(t('notestutorial', 'Could not fetch notes'))
	}
	loading.value = false
})
</script>
<style scoped>
	#app-content > div {
		width: 100%;
		height: 100%;
		padding: 20px;
		display: flex;
		flex-direction: column;
		flex-grow: 1;
	}

	input[type='text'] {
		width: 100%;
	}

	textarea {
		flex-grow: 1;
		width: 100%;
	}
</style>
