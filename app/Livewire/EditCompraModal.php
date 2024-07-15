<?php

namespace App\Livewire;

use Livewire\Component;

class EditCompraModal extends Component
{
    public $mostrarModal = false; // Nuevo estado para controlar la visibilidad del modal

    public function render()
    {
        return view('livewire.edit-compra-modal');
    }
    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }
}
