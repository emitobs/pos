<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;



class PermissionController extends Component
{
    use WithPagination;

    public  $permissionName, $search, $selected_id, $componentName, $pageTitle;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->componentName = "Permisos";
        $this->pageTitle = 'Listado';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $permission = Permission::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $permission = Permission::orderBy('name', 'asc')->paginate($this->pagination);
        }

        return view(
            'livewire.permissions.component',
            ['permissions' => $permission]
        )->extends('layouts.theme.app')->section('content');
    }
    public function CreatePermission()
    {
        $rules = [
            'permissionName' => 'required|unique:permissions,name|min:2'
        ];
        $messages = [
            'permissionName.required' => 'Nombre de rol requerido',
            'permissionName.unique' => 'El nombre ingresado ya existe',
            'permissionName.min' => 'El nombre debe de tener como minimo 2 caracteres',
        ];
        $this->validate($rules, $messages);
        Permission::create(['name' => $this->permissionName]);
        $this->emit('permission-added', 'El permiso se ha registrado con exito');
        $this->resetUI();
    }
    public function Edit($id)
    {
        $permission = Permission::find($id);
        $this->selected_id = $permission->id;
        $this->permissionName = $permission->name;

        $this->emit('show-modal', 'ShowModal');
    }

    public function UpdatePermission()
    {
        $rules = [
            'permissionName' => "required|unique:permissions,name, {$this->selected_id}|min:3"
        ];
        $messages = [
            'permissionName.required' => 'Nombre requerido',
            'permissionName.unique' => 'El nombre ingresado ya existe',
            'permissionName.min' => 'El nombre debe de tener como minimo 2 caracteres',
        ];

        $this->validate($rules, $messages);

        $role = Permission::find($this->selected_id);
        $role->name = $this->permissionName;
        $role->save();
        $this->emit('permission-updated', 'El permiso se actualizo con exito');
        $this->resetUI();
    }
    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

    public function destroy($id)
    {
        Permission::find($id)->delete();
        $this->emit('permission-deleted', 'Permiso eliminado correctamente.');
    }
    public function resetUI()
    {
        $this->permissionName = "";
        $this->search = "";
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
