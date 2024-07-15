<?php

namespace App\Livewire;

use App\Models\Compra;
use Livewire\Component;

class ShoppingList extends Component
{
    public function render()
    {
        return view('livewire.shopping-list');
    }
    public $compras; // Propiedad para almacenar la lista de compras
    public $completada;
    public $mostrarModal = false; // Nuevo estado para controlar la visibilidad del modal


    public function mount()
    {
        $this->compras = Compra::all();
    }
    public $nuevaCompra = [
        'nombre' => '',
        'cantidad' => 1,
        'precio' => 0.0,
    ];
    public $compra = [];

    public function agregarCompra()
    {
        Compra::create([
            'nombre' => $this->nuevaCompra['nombre'],
            'cantidad' => $this->nuevaCompra['cantidad'],
            'precio' => $this->nuevaCompra['precio'],
            'completada' => false, // Por defecto, no completada
        ]);

        // Actualiza la lista de compras
        $this->compras = Compra::all();

        // Limpia el formulario
        $this->reset('nuevaCompra');
    }
    public function eliminarCompra($compraId)
    {
        $compra = Compra::find($compraId);
        if ($compra) {
            $compra->delete();
            // Elimina la compra de la lista actual
            $this->compras = $this->compras->reject(function ($item) use ($compraId) {
                return $item->id === $compraId;
            });
        }
    }
    public function toggleCompletada($compraId)
    {
        $compra = Compra::find($compraId);
        if ($compra) {
            $compra->update([
                'completada' => !$compra->completada,
            ]);
        }
        $this->compras = Compra::all();
    }
    public function openModal($component, $compraId)
    {
        $this->mostrarModal = true;
    }
}
