<div>
    <h2>Lista de compras</h2>

    <ul>
        @foreach ($compras as $compra)
            <li>
                <input type="checkbox" wire:model="compra.{{ $compra->id }}.completada"
                    wire:click="toggleCompletada({{ $compra->id }})">
                {{ $compra->nombre }} ({{ $compra->cantidad }}) - ${{ $compra->precio }}
                <button wire:click="eliminarCompra({{ $compra->id }})">Eliminar</button>
                <button wire:click="openModal('EditCompraModal', {{ $compra->id }})">Editar</button>
            </li>
        @endforeach
    </ul>
    <!-- Mostrar el modal solo si $mostrarModal es true -->
    @if ($mostrarModal)
        @livewire('edit-compra-modal')
    @endif
    <h3>Agregar nueva compra</h3>

    <form wire:submit.prevent="agregarCompra">
        <input wire:model="nuevaCompra.nombre" name="nombre" placeholder="Nombre" required>
        <input wire:model="nuevaCompra.cantidad" name="cantidad" placeholder="Cantidad" required>
        <input wire:model="nuevaCompra.precio" name="precio" step="0.01" placeholder="Precio" required>
        <button type="submit">Agregar</button>
    </form>
</div>
