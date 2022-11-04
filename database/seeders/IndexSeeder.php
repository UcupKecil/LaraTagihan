<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class IndexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $superadmin = Role::create([
            'name' => 'admin',
        ]);

        $admin = Role::create([
            'name' => 'petugas',
        ]);

        $user = Role::create([
            'name' => 'penghuni',
        ]);

        $permission = Permission::create([
            'name' => 'read-kelas',
        ]);

        $admin->givePermissionTo($permission);
        $user->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'create-kelas',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'edit-kelas',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'delete-kelas',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'read-penghuni',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'create-penghuni',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'edit-penghuni',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'delete-penghuni',
        ]);
        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'read-ipl',
        ]);
        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'create-ipl',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'edit-ipl',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'delete-ipl',
        ]);
        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'read-konfirmasi',
        ]);
        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);
        $user->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'create-konfirmasi',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);
        $user->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'edit-konfirmasi',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);
        $user->givePermissionTo($permission);

        $permission = Permission::create([
            'name' => 'delete-konfirmasi',
        ]);

        $admin->givePermissionTo($permission);
        $superadmin->givePermissionTo($permission);
        $user->givePermissionTo($permission);

        $data   = [
            'username'      => 'admin',
            'email'     => 'admin@mail.com',
            'password'  => Hash::make('12345678')
        ];

        $user = User::create($data);

        $user->syncRoles('admin');

        $data   = [
            'username'      => 'petugas',
            'email'     => 'petugas@mail.com',
            'password'  => Hash::make('12345678')
        ];

        $user = User::create($data);

        $user->syncRoles('petugas');

        // $data   = [
        //     'username'      => 'penghuni1',
        //     'email'     => 'user@mail.com',
        //     'password'  => Hash::make('12345678')
        // ];

        // $userData = User::create($data);
        // $userData->syncRoles('penghuni');
    }
}
