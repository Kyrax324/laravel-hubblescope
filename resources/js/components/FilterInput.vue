<template>
	<v-row class="ma-0" dense>
		<v-col cols="12">
			<v-row dense align="center">
				<v-col cols="auto">
					<div class="text-body-1 pl-2">Advance Attributes:</div>
				</v-col>
				<v-col cols="auto">
					<v-btn
						icon
						@click="bindAction('new', newFilterObj())"
					>
						<v-icon>mdi-plus-circle</v-icon>
					</v-btn>
				</v-col>
			</v-row>
		</v-col>
		<v-col cols="12">
			<v-row dense>
				<template v-for="(field, index) in value_">
					<v-col :key="index" cols="auto">
						<v-chip
							small
							@click="bindAction('edit', field, index)"
						>
							{{ `${field.key} ${field.operator} '${field.value}'` }}
						</v-chip>
					</v-col>
				</template>
			</v-row>
		</v-col>

		<v-dialog
			v-model="formDialog"
			persistent max-width="650"
			scrollable
		>
			<v-card>
				<v-card-title class="primary">
					<v-row>
						<v-col><span class="text-capitalize">{{ formAction }}</span> Attributes</v-col>
						<v-col v-if="formAction != 'new'" cols="auto">
							<v-btn
								small
								color="error"
								class="text-capitalize"
								@click="()=>{
									removeField()
									closeDialog()
								}"
							>
								Remove
							</v-btn>
						</v-col>
					</v-row>
				</v-card-title>
				<v-divider class="ma-0"></v-divider>
				<v-card-text class="px-3 pt-2 pb-0">
					<v-row dense align="center" class="pt-1 pb-2 ma-0">
						<v-col cols="12" md="7">
							<v-text-field
								v-model="form.key"
								placeholder="key"
								outlined
								dense
								hide-details
							></v-text-field>
						</v-col>
						<v-col cols="12" md="5">
							<v-select
								v-model="form.operator"
								placeholder="operator"
								:items="operationOptions"
								outlined
								dense
								hide-details
							></v-select>
						</v-col>
						<v-col cols="12" md="12">
							<v-text-field
								v-model="form.value"
								placeholder="value"
								outlined
								dense
								hide-details
							></v-text-field>
						</v-col>
						<v-col v-if="formAction == 'new' " cols="12">
							<v-divider class="my-1"></v-divider>
							<div class="text-caption">Quick Actions:</div>
							<v-row dense class="ma-0 pt-1">
								<template v-for="(shortcut, i) in shortcuts">
									<v-col :key="i" cols="auto">
										<v-chip
											color="info darken-3"
											small
											@click="bindAction('new', newFilterObj(shortcut.key, shortcut.value, shortcut.operator))"
										>
											<v-icon left small>mdi-lightning-bolt-circle</v-icon>
											{{ shortcut.text }}
										</v-chip>
									</v-col>
								</template>
							</v-row>
						</v-col>
					</v-row>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn
						small
						class="text-capitalize"
						text
						@click="closeDialog()"
					>
						Cancel
					</v-btn>
					<v-btn
						small
						class="text-capitalize"
						color="primary"
						:disabled="form.key == ''"
						@click="submit()"
					>
						Save
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</v-row>
</template>

<script>
import cloneDeep from 'lodash/cloneDeep'
export default {
	props:{
		value: {
			type: Array,
			default: null
		}
	},
	data(){
		return {
			value_: null,
			form: {},
			formAction: null,
			formDialog: false,
			operationOptions: [],
			shortcuts: [],
		}
	},
	watch:{
		"value": {
			handler(newVal, oldVal){
				this.value_ = newVal;
			},
			immediate: true,
		}
	},
	created(){
		this.operationOptions = window.operationOptions
		this.shortcuts = window.shortcutSuggestions
	},
	methods:{
		newFilterObj(key = '', value = '', operator = 'like'){
			return {
				key: key,
				value: value,
				operator: operator,
			}
		},
		bindAction(action, item, index = 0){
			this.formAction = action
			item.index = index
			this.form = cloneDeep(item)
			this.formDialog = true
		},
		removeField(){
			this.value_.splice(this.form.index, 1)
		},
		closeDialog(){
			this.formDialog = false
		},
		submit(){
			if(this.formAction != 'new'){
				this.removeField()
			}
			this.value_.push(this.form)
			this.$emit("input", this.value_)
			this.closeDialog()
		},
	}
}
</script>