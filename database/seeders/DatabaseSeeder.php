<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //create super Admin
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'name_ar' => 'سوبر ادمن',
            'email' => 'admin@gmail.com',
            'email_verified_at' => date('Y-m-d h:i:s'),
            'password' => Hash::make('123456789'),
            'phone' => '1234567890',
            'phone_verified_at' => date('Y-m-d h:i:s'),
        ]);

        //CreateRoles
        $role = Role::create(['name' => 'Super Admin']);

        $user->assignRole($role);

        //addingPermissions
        $pers = ['Roles', 'Role_Create','Role_Edit','Role_Delete','Users','Users_Create','Users_Update','Users_Delete'];
        foreach($pers as $per) {
           $permission = Permission::create([
            'name' => $per,
            'guard_name' => 'web',
           ]);
          $role->givePermissionTo($permission);
        }


        // Create Genders
        \App\Models\Gender::create(
            [
                'user_id' => 1,
                'name_en' => 'Male',
                'name_ar' => 'ذكر',
            ]
        );
        \App\Models\Gender::create(
            [
                'user_id' => 1,
                'name_en' => 'Female',
                'name_ar' => 'أنثي',
            ]
        );

        //Add Countries
        \App\Models\Country::create([
                'user_id' => 1,
                'name_en' => 'Egypt',
                'name_ar' => 'مصر',
                'code' => 'EG'
        ]);
        \App\Models\Country::create([
            'user_id' => 1,
            'name_en' => 'Saudi Arabia',
            'name_ar' => 'السعودية',
            'code' => 'SA'
        ]);

        //Add Job
        \App\Models\Job::create([
            'user_id' => 1,
            'name_en' => 'Military Employee',
            'name_ar' => 'موظف عسكري',
        ]);

        //Add Nationalities
        \App\Models\Nationality::create([
            'user_id' => 1,
            'name_en' => 'Egyption',
            'name_ar' => 'مصري',
        ]);


        //Add Language
        \App\Models\Language::create([
            'user_id' => 1,
            'name_en' => 'Arabic',
            'name_ar' => 'العربية',
            'code' => '(ع)'
        ]);
        \App\Models\Language::create([
            'user_id' => 1,
            'name_en' => 'English',
            'name_ar' => 'الانجليزية',
            'code' => '(EN)'
        ]);
    }
}
