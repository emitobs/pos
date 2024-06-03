<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Supplier;

class Suppliers extends Component
{
    public $name, $contactPerson, $email, $phone, $address, $rut, $selected_id;
    public function render()
    {
        $suppliers = Supplier::all();
        return view('livewire.suppliers.suppliers',['suppliers' => $suppliers])->extends('layouts.theme.app')
            ->section('content');
        ;
    }

    public function createSupplier()
    {
        $this->emit('show-modal');
    }

    public function saveSuppliers()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $supplier = new Supplier();
        $supplier->name = $this->name;
        $supplier->contactPerson = $this->contactPerson;
        $supplier->email = $this->email;
        $supplier->phone = $this->phone;
        $supplier->address = $this->address;
        $supplier->rut = $this->rut;
        $supplier->save();
        $this->emit('hide-modal');
        $this->resetUI();
    }

    public function editSupplier(Supplier $supplier){
        $this->selected_id = $supplier->id;
        $this->name = $supplier->name;
        $this->contactPerson = $supplier->contactPerson;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;
        $this->address = $supplier->address;
        $this->rut = $supplier->rut;
        $this->emit('show-modal');

    }

    public function resetUI()
    {
        $this->name = '';
        $this->contactPerson = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->rut = '';
        $this->selected_id = '';
    }
}
