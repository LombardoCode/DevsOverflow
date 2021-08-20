<template>
  <input type="submit" class="w-full px-3 py-4 rounded-md text-white font-bold cursor-pointer bg-blue-600 hover:bg-blue-700 transition-all duration-100 outline-none" :value="texto">
</template>

<script>
export default {
	props: {
		texto: String
	}
}
</script>

<style>

</style>
