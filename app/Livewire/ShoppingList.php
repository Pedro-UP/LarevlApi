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
    public $total; // Propiedad para almacenar la lista de compras
    public $completada;
    public $modoEdicion = false; // Define la variable $modoEdicion

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
    public $comprasSeleccionadas = [];
    public function toggleCompletada($compraId)
    {
        $compra = Compra::find($compraId);
        if ($compra) {
            $compra->update([
                'completada' => !$compra->completada,
            ]);

            // Agrega o elimina la compra del array según su estado
            if ($compra->completada) {
                $this->comprasSeleccionadas[] = $compraId;
            } else {
                $this->comprasSeleccionadas = array_diff($this->comprasSeleccionadas, [$compraId]);
            }

            // Recalcula el total considerando precio y cantidad de las compras seleccionadas
            $this->total = $this->calcularTotal();
        }
    }

    public function calcularTotal()
    {
        $total = 0;
        foreach ($this->comprasSeleccionadas as $compraId) {
            $compra = Compra::find($compraId);
            if ($compra) {
                $total += $compra->precio * $compra->cantidad;
            }
        }
        return $total;
    }
    public function eliminarComprasSeleccionadas()
    {
        // Verifica si hay compras seleccionadas
        if (count($this->comprasSeleccionadas) >= 0) {
            // Elimina las compras seleccionadas de la base de datos
            Compra::whereIn('id', $this->comprasSeleccionadas)->delete();
            // Filtra la lista de compras actual para eliminar las seleccionadas
            $this->compras = $this->compras->reject(function ($compra) {
                return in_array($compra->id, $this->comprasSeleccionadas);
            });
            // Limpia el array de compras seleccionadas
            $this->comprasSeleccionadas = [];
            // Recalcula el total si es necesario
            $this->total = $this->calcularTotal();
        }
    }

    public function editarCompra($compraId)
    {
        // Obtén la compra existente por su ID
        $compra = Compra::find($compraId);
        $this->modoEdicion = true;
        // Actualiza las propiedades del componente con los detalles de la compra
        $this->compra = [
            'id' => $compra->id,
            'nombre' => $compra->nombre,
            'cantidad' => $compra->cantidad,
            'precio' => $compra->precio,
        ];
    }
    public function guardarEdicion()
    {
        // Actualiza la compra existente con los valores del formulario
        $compraExistente = Compra::find($this->compra['id']);
        if ($compraExistente) {
            $compraExistente->update([
                'nombre' => $this->compra['nombre'],
                'cantidad' => $this->compra['cantidad'],
                'precio' => $this->compra['precio'],
            ]);
        }

        // Actualiza la lista de compras
        $this->compras = Compra::all();

        // Limpia la propiedad $compra y vuelve al estado normal
        $this->compra = [];
        $this->modoEdicion = false;
    }
    public function cancelarEdicion()
    {
        $this->modoEdicion = false;
    }
}
