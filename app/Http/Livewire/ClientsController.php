<?php

namespace App\Http\Livewire;

use App\Models\Address;
use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;


class ClientsController extends Component
{

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public $componentName = 'Clientes', $selected_id, $name, $telephone, $address, $search;


    public function render()
    {
        $clients = [];
        if (strlen($this->search) > 0) {
            $clients = Client::where(function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('telephone', 'LIKE', '%' . $this->search . '%');
            })->where('disabled', 0)->paginate(8);
        } else {
            $clients = Client::where('disabled', 0)->paginate(8);
        }

        return view('livewire.clients.clients', ['clients' => $clients])->extends('layouts.theme.app')->section('content');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name.required' => 'Nombre obligatorio'
        ];
        $this->validate($rules, $messages);
        $client = Client::create([
            'name' => $this->name,
            'telephone' => $this->telephone
        ]);
        if ($client) {
            if ($this->address) {
                $address = Address::create([
                    'address' => $this->address,
                    'client_id' => $client->id,
                    'default' => 1
                ]);
            }
            $this->emit('stored_client');
            $this->resetUI();
        }
    }

    public function Edit(Client $client)
    {
        $this->selected_id = $client->id;
        $this->name = $client->name;
        $this->telephone = $client->telephone;
        $this->address = $client->default_address;
        $this->emit('edit_client');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->name = '';
        $this->telephone = '';
        $this->address = '';
    }

    public function see_debts($client)
    {
        return redirect()->to('/debts?client_id=' . $client);
    }
}
