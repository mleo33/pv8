<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programmerRole = Role::create(['name' => 'programador']);
        $gerenteRole = Role::create(['name' => 'gerente']);
        $vendedorMostrador = Role::create(['name' => 'vendedor-de-mostrador']);

        Permission::create(['name' => 'ver-usuarios'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'crear-usuarios'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'editar-usuarios'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'eliminar-usuarios'])->syncRoles([$programmerRole, $gerenteRole]);

        Permission::create(['name' => 'ver-productos'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'crear-productos'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'editar-productos'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'eliminar-productos'])->syncRoles([$programmerRole, $gerenteRole]);

        Permission::create(['name' => 'ver-inventario'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'editar-inventario'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'eliminar-inventario'])->syncRoles([$programmerRole, $gerenteRole]);

        Permission::create(['name' => 'ver-clientes'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'crear-clientes'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'editar-clientes'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'eliminar-clientes'])->syncRoles([$programmerRole, $gerenteRole]);

        Permission::create(['name' => 'ver-sucursales'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'crear-sucursales'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'editar-sucursales'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'eliminar-sucursales'])->syncRoles([$programmerRole, $gerenteRole]);

        Permission::create(['name' => 'ver-proveedores'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'crear-proveedores'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'editar-proveedores'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'eliminar-proveedores'])->syncRoles([$programmerRole, $gerenteRole]);

        Permission::create(['name' => 'realizar-corte'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'registrar-ingresos'])->syncRoles([$programmerRole, $gerenteRole]);
        Permission::create(['name' => 'registrar-egresos'])->syncRoles([$programmerRole, $gerenteRole]);
    }
}
