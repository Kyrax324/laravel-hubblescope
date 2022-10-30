<template>
	<v-sheet class="pt-4" color="transparent">
		<v-card>
			<v-card-title class="row no-gutters ma-0 py-3 primary">
				<v-row dense justify="space-between">
					<v-col cols="auto" md="3">
						<v-select
							v-model="mode"
							outlined
							color="white"
							:items="modeOptions"
							dense
							hide-details
							return-object
							@input="search"
						></v-select>
					</v-col>
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
				</v-row>
			</v-card-title>
			<v-divider class="ma-0"></v-divider>
			<v-card-text class="pa-0 px-1 pt-3">
				<filter-input-card
					v-model="fields"
					:mode="mode"
				></filter-input-card>
			</v-card-text>
			<v-card-actions class="pb-4">
				<v-spacer></v-spacer>
				<v-btn
					color="primary"
					text
					class="text-capitalize px-4"
					:loading="searchLoading"
					x-small
					@click="dumpQuery()"
				>
					<v-icon left small>mdi-creation</v-icon>
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
					<div
						class="text-truncate text-caption"
						style="max-width: 400px;"
						:title="item.content.uri"
					>
						{{ item.content.uri }}
					</div>
				</template>
				<template #[`item.content.sql`]="{ item }">
					<div
						class="text-truncate text-caption"
						style="max-width: 500px;"
						:title="item.content.sql"
					>
						{{ item.content.sql }}
					</div>
				</template>
				<template #[`item.created_at`]="{ item }">
					<div class="text-caption">{{ $dayjs(item.created_at).format('YYYY-MM-DD hh:mma') }}</div>
				</template>
				<template #[`item.action`]="{ item }">
					<v-btn
						icon small
						target="_blank"
						title="View on Telescope"
						:href="item.telescope_link"
						class="text-capitalize"
					>
						<v-icon small>mdi-satellite-variant</v-icon>
					</v-btn>
					<v-btn icon small @click="viewContent(item)">
						<v-icon small>mdi-information-outline</v-icon>
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
import FilterInputCard from './FilterInputCard.vue';
export default {
	components: { ContentCard, FilterInputCard },
	data(){
		return {
			mode: null,
			tags: null,
			fields: [],
			searchLoading: false,
			records: [],
			queryText: null,
			paginator: {},
			dataTableOption: {},
			contentViewerDialog: false,
			contentViewerItem: null,
			modeOptions: [],
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
	computed:{
		dataTableHeaders(){

			let headers = this.mode?.headers

			if(headers == null){
				headers = [
					{ text: 'uuid', value: 'uuid' },
				]
			}

			return headers.concat([
				{ text: 'Created At', value: 'created_at' },
				{ text: '', value: 'action' },
			])
		}
	},
	created(){
		this.modeOptions = window.availableModes;
		this.mode = this.modeOptions[0]
	},
	methods:{
		search(){
			this.searchLoading = true
			this.queryText = null
			this.records = []

			let { page, itemsPerPage } = this.dataTableOption

			let payload = {
				type: this.mode.value,
				tags: this.tags,
				fields: this.fields,
				page: page,
				itemsPerPage: itemsPerPage,
			}

			let prefix = window.hubblescope.prefix
			axios.post(prefix+"/hubblescope-api/search", payload).then((res)=>{
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
				type: this.mode.value,
				tags: this.tags,
				fields: this.fields,
			}

			let prefix = window.hubblescope.prefix
			axios.post(prefix+"/hubblescope-api/dump-query", payload).then((res)=>{
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