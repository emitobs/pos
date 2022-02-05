<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class AssignPermissionToRoleController extends Component
{

    use WithPagination;

    public $role, $componentName, $permissionsSelected = [], $old_permissions = [], $pageTitle;
    private $pagination = 10;


    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->role = 'Elegir';
        $this->componentName = 'Asignar permisos';
        $this->pageTitle = '';
    }
    public function render()
    {
        $permissions = Permission::select('name', 'id', DB::raw("0 as checked"))
            ->orderby('name', 'asc')
            ->paginate($this->pagination);

        if ($this->role != 'Elegir') {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
                ->where('role_id', $this->role)
                ->pluck('permissions.id')->toArray();

            $this->old_permissions = $list;
        }

        if ($this->role != 'Elegir') {
            foreach ($permissions as $permission) {
                $role = Role::find($this->role);
                $hasPermission = $role->hasPermissionTo($permission->name);
                if ($hasPermission) {
                    $permission->checked = 1;
                }
            }
        }

        return view('livewire.AssignPermissionToRole.component', [
            'roles' => Role::orderBy('name', 'asc')->get(),
            'permissions' => $permissions
        ])->extends('layouts.theme.app')->section('content');
    }

    public $listeners = ['DesyncAll'];

    public function DesyncAll()
    {
        if ($this->role == 'Elegir') {
            $this->emit('sync-error', 'Selecciona un role válido');
            return;
        }

        $role = Role::find($this->role);
        $role->syncPermissions([0]);
        $this->emit('removeall', "Se revocaron todos los permisos al role $role->name ");
    }

    public function SyncAll()
    {
        if ($this->role == 'Elegir') {
            $this->emit('sync-error', 'Selecciona un role valido');
            return;
        }
        $role = Role::find($this->role);
        $permissions = Permission::pluck('id')->toArray();
        $role->syncPermissions($permissions);
        $this->emit('syncall', "Se sincronizaron todos los permisos al role $role->name");
    }

    public function syncPermission($state, $permissionName)
    {
        if ($this->role != 'Elegir') {
            $roleName = Role::find($this->role);

            if ($state) {
                $roleName->givePermissionTo($permissionName);
                $this->emit('permi', "Permiso asignado correctamente.");
            } else {
                $roleName->rovekePermissionTo($permissionName);
                $this->emit('permi', "Permiso elimando correctamente");
            }
        }
    }
}
