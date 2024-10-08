<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Config;

class ColorPicker extends Component
{
    public $color, $element;

    protected $listeners = ['saveColors'];
    public function mount($element, $color)
    {
        $this->element = $element;
        $this->color = $color;
    }

    public function render()
    {
        return view('livewire.colorPicker.color-picker');
    }

    public function updateColor($color)
    {
        $this->emit('color-updated', [$this->color, $this->element]);
    }

    // public function saveColors()
    // {
    //     $config = Config::first();
    //     $config->{$this->element} = $this->color;
    //     $config->save();
    //     $this->emit('colors-saved', $this->element);
    // }

    public function saveColors()
    {
        $config = Config::first();
        // Verificar si el color ha cambiado realmente
        if ($config->{$this->element} !== $this->color) {
            $config->{$this->element} = $this->color;
            $config->save();
            // Emitir evento solo si este controlador cambió el color
            $this->emit('colors-saved', $this->element);
        }
    }
}
