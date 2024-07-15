<!-- edit-compra-modal.blade.php -->

<div id="mi-modal" class="fixed inset-0 flex items-center justify-center">
    <div class="absolute bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Editar Compra</h2>
        <p>Hola Mundo</p>

        <!-- Botón de cancelar -->
        <button wire:click="cerrarModal"
            class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Cancelar
        </button>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('modalCerrado', function () {
            // Cierra el modal
            document.getElementById('mi-modal').style.display = 'none';
        });
    });
</script>
