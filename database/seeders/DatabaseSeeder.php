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
            'job_id' => 1,
            'country_id' => 1,
            'nationality_id' =>1,
            'lang_id' => 1,
            'is_active' => 1,
        ]);

        //CreateRoles
        $role = Role::create(['name' => 'Super Admin']);

        $user->assignRole($role);

        //addingPermissions
        $pers = [
                'Roles',
                'Role_Create',
                'Role_Edit',
                'Role_Delete',
                'Users',
                'Users_Create',
                'Users_Update',
                'Users_Delete',
                'Country_View',
                'Country_Create',
                'Country_Update',
                'Country_Delete',
                'Currency_View',
                'Currency_Create',
                'Currency_Update',
                'Currency_Delete',
                'Gender_View',
                'Gender_Create',
                'Gender_Update',
                'Gender_Delete',
                'Job_View',
                'Job_Create',
                'Job_Update',
                'Job_Delete',
                'Language_View',
                'Language_Create',
                'Language_Update',
                'Language_Delete',
                'Nationality_View',
                'Nationality_Create',
                'Nationality_Update',
                'Nationality_Delete',
            'Services','Services_Create','Services_Update','Services_Delete',
            'KfaratChoice','KfaratChoice_Create','KfaratChoice_Update','KfaratChoice_Delete',
            'Wallet','Wallet_Create','Wallet_Update','Wallet_Delete',
        ];
        foreach($pers as $per) {
           $permission = Permission::create([
            'name' => $per,
            'guard_name' => 'web',
           ]);
          $role->givePermissionTo($permission);
        }

        //Create Currency
        \App\Models\Currency::create([
            'user_id' => 1,
            'name_en' => 'Suadian Ryial',
            'name_ar' => 'ريال سعودي',
            'convert_value' => 1,
            'symbol' => 'SAR'
        ]);

        // Create Wallet
        \App\Models\Wallet::create([
            'user_id' => 1,
            'currency_id' => 1,
            'amount' => 0,
        ]);

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
