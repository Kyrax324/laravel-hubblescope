<template>
	<v-card v-if="dataObj">
		<v-card-title class="row no-gutters ma-0 primary py-2 px-4">
			<v-col cols="auto">
				<v-btn
					outlined
					target="_blank"
					:href="dataObj.telescope_link"
					class="text-capitalize"
				>
					View On Telescope
				</v-btn>
			</v-col>
			<v-spacer></v-spacer>
			<v-col cols="auto">
				<v-btn
					class="text-capitalize"
					@click="emitClose()"
				>
					Close
				</v-btn>
			</v-col>
		</v-card-title>
		<v-card-text class="pa-0">
			<JsonPretty
				:data="dataObj"
				show-line-number
				show-icon
				virtual
				:height="800"
				class="fill-height"
			></JsonPretty>
		</v-card-text>
	</v-card>
</template>

<script>
import VueJsonPretty from 'vue-json-pretty';
import 'vue-json-pretty/lib/styles.css';
export default {
	components:{
		JsonPretty: VueJsonPretty,
	},
	props:{
		dataObj: {
			type: Object,
			default: null
		}
	},
	methods:{
		emitClose(){
			this.$emit("close")
		},
	}
}
</script>

<style>
.vjs-tree-node.is-highlight, .vjs-tree-node:hover {
	background-color: #1e323b !important;
}
</style>