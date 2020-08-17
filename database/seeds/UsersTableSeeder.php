<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('123456789'),
            'phone' => '01121184148',
            'country_id' => '1',
            'gender' => 'male',
            'profile' => 'images/3nk6F9x3XDRjtQqivwrETbfykg39YRBkNKfqJ7ul.jpeg',
            'type' => 'admin',
        ]);


        $user->attachRole('superadministrator');

        $country = \App\Country::create([
            'name_ar' => 'الكويت',
            'name_en' => 'Kuwait',
            'code' => '00965',
            'currency' => 'KWD',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',

        ] , [
            'name_ar' => 'مصر',
            'name_en' => 'Egypt',
            'code' => '002',
            'currency' => 'EGP',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',

        ]);


        $learning_system = \App\LearningSystem::create([
            'name_ar' => 'التعليم الاساسي',
            'name_en' => 'basic learning',
            'description_ar' => 'التعليم الاساسي',
            'description_en' => 'basic learning',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',

        ]);

        $learning_system->countries()->attach('1');

        $stage = \App\Stage::create([
            'name_ar' => 'المرحلة الابتدائية',
            'name_en' => 'Primary School',
            'learning_system_id' => '1',
        ]);


        $ed_class = \App\EdClass::create([
            'name_ar' => 'الصف الأول الابتدائي',
            'name_en' => 'primary one',
            'stage_id' => '1',
        ]);

    }
}
