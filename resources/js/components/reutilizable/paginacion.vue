<template>
	<vue-ads-pagination
		:total-items="200"
		:max-visible-pages="5"
		:page="page"
		:loading="loading"
		@page-change="pageChange"
		@range-change="rangeChange"
	>
		<template slot-scope="props">
			<div class="vue-ads-pr-2 vue-ads-leading-loose">
				Items {{ props.start }} tot {{ props.end }} van de {{ props.total }}
			</div>
		</template>
		<template
			slot="buttons"
			slot-scope="props"
		>
			<vue-ads-page-button
				v-for="(button, key) in props.buttons"
				:key="key"
				v-bind="button"
				@page-change="page = button.page"
			/>
		</template>
	</vue-ads-pagination>
</template>

<script>
import VueAdsPagination, { VueAdsPageButton } from 'vue-ads-pagination';

export default {
	components: {
		VueAdsPagination,
		VueAdsPageButton,
	},
	methods: {
		pageChange (page) {
			this.page = page;
			console.log(page);
		},
		rangeChange (start, end) {
			console.log(start, end);
		},
	},
}
</script>

<style>

</style>
