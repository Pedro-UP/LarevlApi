<div class="bg-stone-500 py-8">
    <div class="max-w-lg mx-auto p-4 px-4">
        <h2 class="text-2xl font-bold text-white mb-4">Lista de Compras</h2>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <ul class="space-y-4">
                @foreach ($compras as $compra)
                    <li>
                        <input type="checkbox" wire:model="compra.{{ $compra->id }}.completada"
                            wire:click="toggleCompletada({{ $compra->id }})">
                        {{ $compra->nombre }} ({{ $compra->cantidad }}) - ${{ $compra->precio }}
                        <button wire:click="eliminarCompra({{ $compra->id }})">Eliminar</button>
                        <button wire:click="editarCompra({{ $compra->id }})">Editar</button>
                    </li>
                @endforeach

                <h3>Total: ${{ number_format($total, 2) }}</h3>

            </ul>
            <!-- Botón para limpiar compras seleccionadas -->
            <button wire:click="eliminarComprasSeleccionadas" @if (count($comprasSeleccionadas) == 0) disabled @endif>Limpiar
                seleccionados</button>

            @if (!empty($compra) && isset($compra['id']) && $modoEdicion)
                <!-- Mostrar el formulario de edición aquí -->
                <h3>Editar compra</h3>
                <form wire:submit.prevent="guardarEdicion">
                    <input wire:model="compra.nombre" name="nombre" placeholder="Nombre" required>
                    <input wire:model="compra.cantidad" name="cantidad" placeholder="Cantidad" required>
                    <input wire:model="compra.precio" name="precio" step="0.01" placeholder="Precio" required>
                    <button type="submit">Guardar</button>
                    <button wire:click="cancelarEdicion">Cancelar</button>
                </form>
            @endif


            <h3>Agregar nueva compra</h3>

            <form wire:submit.prevent="agregarCompra">
                <input wire:model="nuevaCompra.nombre" name="nombre" placeholder="Nombre" required>
                <input wire:model="nuevaCompra.cantidad" name="cantidad" placeholder="Cantidad" required>
                <input wire:model="nuevaCompra.precio" name="precio" step="0.01" placeholder="Precio" required>
                <button type="submit">Agregar</button>
            </form>
        </div>
    </div>
</div>
