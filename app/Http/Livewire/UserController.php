<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Component
{

    use WithPagination;
    use WithFileUploads;


    public
    $name,
    $phone,
    $email,
    $status,
    $image,
    $password,
    $password_confirmation,
    $selected_id,
    $fileLoaded,
    $role,
    $pageTitle,
    $componentName,
    $search;


    private $pagination = 8;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    protected $listeners = [
        'createUser',
        'editUser',
        'resetUI'
    ];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->status = 'Elegir';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = User::where('name', 'like', '%' . $this->search . '%')
                ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = User::orderBy('name', 'asc')->paginate($this->pagination);
        }
        return view('livewire.users.component', [
            'data' => $data,
            'roles' => Role::orderBy('name', 'asc')->get(),
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = '';
        $this->search = '';
        $this->status = '';
        $this->selected_id = 0;
        $this->password_confirmation = '';
        $this->role = 'default';
    }

    public function editUser(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->roles->first()->id;
        $this->emit('show-modal');
    }

    public function createUser()
    {
        $this->emit('show-modal');
    }

    public function saveUser()
    {
        $rules = [
            'name' => 'required|max:255|min:6',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'role' => 'required'
        ];

        $messages = [
            'name.required' => 'Campo requerido',
            'name.min' => 'Se necesita 6 caracteres',
            'name.max' => 'Maximo 255 caracteres',
            'email.required' => 'Se necesita email',
            'password' => 'Se requiere contraseña.',
            'password_confirmation.min' => 'La contraseña debe contener al menos 8 caracteres.',
            'email.required' => 'Se requiere email.',
            'email.unique' => 'Existe paciente con mismo email.',
            'role.required' => 'Se debe especificar un role'
        ];

        $this->validate($rules, $messages);

        if ($this->role > 0) {
            $role = Role::find($this->role);
            if ($role) {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'status' => 'ACTIVE'
                ]);
                $user->assignRole($role->name);
                $user->save();
                $this->resetUI();
                $this->emit('user_added');
            }
        }
    }
}
