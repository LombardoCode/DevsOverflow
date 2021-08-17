<template>
	<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
		<div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
			<div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" aria-hidden="true" @click="cerrarModal()"></div>
			<span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
			<div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
				<div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
					<div class="sm:flex sm:items-start">
						<div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
							<svg class="h-6 w-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
							</svg>
						</div>
						<div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
							<h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
								Parece que no estás registrado...
							</h3>
							<div class="mt-2 text-sm text-gray-500">
								<p>Registrate hoy mismo en DevsOverflow y podrás:</p>
								<ul class="mt-1">
									<li class="razon flex">
										<div class="text-blue-500 mr-2">
											<font-awesome-icon icon="check"/>
										</div>
										<span>
											Publicar preguntas
										</span>
									</li>
									<li class="razon flex">
										<div class="text-blue-500 mr-2">
											<font-awesome-icon icon="check"/>
										</div>
										<span>
											Responder preguntas
										</span>
									</li>
									<li class="razon flex">
										<div class="text-blue-500 mr-2">
											<font-awesome-icon icon="check"/>
										</div>
										<span>
											Votar preguntas y respuestas
										</span>
									</li>
									<li class="razon flex">
										<div class="text-blue-500 mr-2">
											<font-awesome-icon icon="check"/>
										</div>
										<span>
											¡Y mucho más!
										</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
					<a href="/registrarse" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
						Crear una nueva cuenta
					</a>
					<button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="cerrarModal()">
						Cancelar
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCheck } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faCheck)
export default {
	methods: {
		cerrarModal() {
			this.$emit('cerrarModal')
		}
	}
}
</script>

<style>

</style>
