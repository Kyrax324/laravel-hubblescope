<template>
	<v-sheet class="pt-4" color="transparent">
		<v-card>
			<v-card-title class="row no-gutters ma-0 py-3 primary">
				<v-col class="font-weight-bold pl-md-2 text-body-1 text-md-h6">Request</v-col>
				<v-col cols="auto" md="4">
					<v-text-field
						v-model="tags"
						placeholder="Search Tags (eg: tag1, tag2)"
						outlined
						color="white"
						dense
						hide-details
						@keyup.enter="search"
					></v-text-field>
				</v-col>
			</v-card-title>
			<v-divider class="ma-0"></v-divider>
			<v-card-text class="pa-0 px-1 pt-3">
				<filter-input
					v-model="fields"
				></filter-input>
			</v-card-text>
			<v-card-actions class="pb-4">
				<v-spacer></v-spacer>
				<v-btn
					color="primary"
					text
					class="text-capitalize px-4"
					:loading="searchLoading"
					small
					@click="dumpQuery()"
				>
					<v-icon left>mdi-creation</v-icon>
					Dump Query
				</v-btn>
				<v-btn
					color="primary"
					class="text-capitalize px-4"
					:loading="searchLoading"
					small
					@click="search()"
				>
					<v-icon left>mdi-magnify</v-icon>
					Search
				</v-btn>
			</v-card-actions>
		</v-card>

		<v-card class="mt-6">
			<div v-if="queryText" class="pa-4">
				<div class="pb-2 pl-2 text-body-1">Query:</div>
				<div class="pa-3 background text-body-2">{{ queryText }}</div>
			</div>
			<v-data-table
				v-else
				ref="dataTable"
				:headers="dataTableHeaders"
				:items="records"
				:options.sync="dataTableOption"
				:server-items-length="paginator.total"
				:footer-props="{
					'items-per-page-options': [10, 25, 50, 100]
				}"
				:loading="searchLoading"
				disable-sort
			>
				<template #[`item.content.uri`]="{ item }">
					<div style="max-width: 170px;" class="text-truncate">{{ item.content.uri }}</div>
				</template>
				<template #[`item.created_at`]="{ item }">
					{{ $dayjs(item.created_at).format('YYYY-MM-DD hh:mma') }}
				</template>
				<template #[`item.action`]="{ item }">
					<v-btn icon small @click="viewContent(item)">
						<v-icon small>mdi-eye</v-icon>
					</v-btn>
				</template>
			</v-data-table>
		</v-card>

		<v-dialog
			v-model="contentViewerDialog" max-width="750px" scrollable
			persistent
			fullscreen
		>
			<content-card
				:data-obj="contentViewerItem"
				@close="contentViewerDialog = false"
			></content-card>
		</v-dialog>
	</v-sheet>
</template>

<script>
import axios from 'axios';
import ContentCard from './ContentCard.vue';
import FilterInput from './FilterInput.vue';
export default {
	components: { ContentCard, FilterInput },
	data(){
		return {
			tags: null,
			fields: [],
			searchLoading: false,
			records: [],
			queryText: null,
			paginator: {},
			dataTableOption: {},
			dataTableHeaders: [],
			contentViewerDialog: false,
			contentViewerItem: null,
		}
	},
	watch: {
		"dataTableOption": {
			handler(){
				this.search()
			},
			deep: true,
		},
	},
	created(){
		this.dataTableHeaders = [
			{ text: 'Method', value: 'content.method' },
			{ text: 'Path', value: 'content.uri' },
			{ text: 'Status', value: 'content.response_status' },
			{ text: 'Created At', value: 'created_at' },
			{ text: '', value: 'action' },
		];
	},
	methods:{
		search(){
			this.searchLoading = true
			this.queryText = null
			this.records = []

			let { page, itemsPerPage } = this.dataTableOption

			let payload = {
				"tags": this.tags,
				"fields" : this.fields,
				"page" : page,
				"itemsPerPage" : itemsPerPage,
			}
			axios.post("/microscope-api/search", payload).then((res)=>{
				let result = res.data.data
				this.records = result.data
				this.paginator = {
					total: result.total,
				}
			}).catch((err)=>{
				console.log(err)
			}).finally(()=>{
				this.searchLoading = false
			})
		},
		dumpQuery(){
			this.searchLoading = true

			let payload = {
				"tags": this.tags,
				"fields" : this.fields,
			}
			axios.post("/microscope-api/dump-query", payload).then((res)=>{
				let result = res.data.data
				this.queryText = result
			}).catch((err)=>{
				console.log(err)
			}).finally(()=>{
				this.searchLoading = false
			})
		},
		viewContent(item){
			this.contentViewerDialog = true
			this.contentViewerItem = item
		}
	}
}
</script>

<style>
.v-input input{
	max-height: 26px !important;
}
.v-input__slot{
	min-height: 32px !important;
}
.v-input__append-inner{
	margin-top: 5px !important;
}
</style>