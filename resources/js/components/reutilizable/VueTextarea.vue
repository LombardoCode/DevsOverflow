<template>
	<div>
		<textarea class="w-full px-3 py-2 rounded-md placeholder-gray-400 ring-2 ring-blue-500 outline-none" v-model="texto" :placeholder="placeholder"></textarea>
	</div>
</template>

<script>
export default {
	props: {
		texto: String,
		placeholder: String
	}
}
</script>

<style>

</style>
