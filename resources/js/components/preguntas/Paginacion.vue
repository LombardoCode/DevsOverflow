<template>
	<vue-ads-pagination v-if="paginacion.totalItems > 0" :total-items="paginacion.totalItems" :max-visible-pages="8"
	:items-per-page="paginacion.itemsMaxPorPag" :page="paginacion.pagina" class="mt-4">
		<template slot-scope="props">
			<div class="vue-ads-pr-2 vue-ads-leading-loose">
				Mostrando {{ props.start.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",") }} de {{ props.end.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",") }} elementos de {{ props.total.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",") }} elementos en total
			</div>
		</template>
		<template slot="buttons" slot-scope="props">
			<div
				v-for="(button, key) in props.buttons"
				:key="key" v-bind="button"
				@click="cambioDePag(button)"
				class="inline-block cursor-pointer select-none"
				:class="{'bg-blue-800 text-white px-5 py-2 rounded mx-1': button.active, 'bg-blue-600 text-white px-5 py-2 rounded mx-1': !button.active}"
			>
				<button v-if="button.title == 'previous'" class="cursor-pointer focus:outline-none">
					<font-awesome-icon icon="arrow-left" />
				</button>
				<button v-if="button.title == 'next'" class="cursor-pointer focus:outline-none">
					<font-awesome-icon icon="arrow-right" />
				</button>
				<button v-if="button.title == '' && button.page != '...'" class="cursor-pointer focus:outline-none">{{button.page+1}}</button>
				<button v-if="button.page == '...'" class="cursor-pointer focus:outline-none">{{button.page}}</button>
			</div>
		</template>
	</vue-ads-pagination>
</template>

<script>
import VueAdsPagination, { VueAdsPageButton } from 'vue-ads-pagination';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faArrowLeft, faArrowRight } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faArrowLeft, faArrowRight)

Vue.component('font-awesome-icon', FontAwesomeIcon)

export default {
	components: {
		VueAdsPagination,
		VueAdsPageButton,
	},
	props: {
		pagina: Number,
		itemsMaxPorPag: Number,
		totalItems: Number
	},
	data() {
		return {
			paginacion: {
				pagina: this.pagina,
				itemsMaxPorPag: this.itemsMaxPorPag,
				totalItems: this.totalItems
			}
		}
	},
	methods: {
		cambioDePag(button) {
			let pagina_maxima = Math.ceil((this.paginacion.totalItems / this.paginacion.itemsMaxPorPag));
			if (button.page > -1 && button.page < pagina_maxima) {
				this.paginacion.pagina = button.page;
			}
			this.$emit("datosDesdePaginacion", {
				pagina: this.paginacion.pagina,
				itemsMaxPorPag: this.paginacion.itemsMaxPorPag,
				totalItems: this.paginacion.totalItems
			});
		},
	},
	watch: {
		pagina: function(newVal, oldVal) {
			this.paginacion.pagina = newVal;
		},
		itemsMaxPorPag: function(newVal, oldVal) {
			this.paginacion.itemsMaxPorPag = newVal;
		},
		totalItems: function(newVal, oldVal) {
			this.paginacion.totalItems = newVal;
		},
	}
}
</script>

<style>

</style>
