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
            'phone' => '+96555657646',
            'country_id' => '1',
            'gender' => 'male',
            'profile' => 'avatarmale.png',
            'type' => 'admin',
            'parent_phone' => '#'
        ]);

        $user1 = \App\User::create([
            'name' => 'islam',
            'email' => 'adffffmin@app.com',
            'password' => bcrypt('123456789'),
            'phone' => '+9655555555',
            'country_id' => '1',
            'gender' => 'male',
            'profile' => 'avatarmale.png',
            'type' => 'teacher',
            'parent_phone' => '#'
        ]);


        $user2 = \App\User::create([
            'name' => 'magdy',
            'email' => 'adfffggfmin@app.com',
            'password' => bcrypt('123456789'),
            'phone' => '+9656666666',
            'country_id' => '1',
            'gender' => 'male',
            'profile' => 'avatarmale.png',
            'type' => 'student',
            'parent_phone' => '#'
        ]);


        $homework = \App\HomeWorkOrder::create([
            'user_id' => '3',
            'teacher_id' => '2',
            'country_id' => '1',
            'user_name' => 'magdy',
            'teacher_name' => 'islam',
            'course_id' => '1',
            'quantity' => '10',
            'total_price' => '50',
            'orderid' => '45454545455',
            'status' => 'done',
            'wallet_balance'=>'0',
        ]);




        $cart = \App\Cart::create([
            'user_id' => '1',
        ]);

        $cart = \App\Cart::create([
            'user_id' => '2',
        ]);

        $cart = \App\Cart::create([
            'user_id' => '3',
        ]);


        \App\Wallet::create([
            'user_id' => '1',
        ]);

        \App\Wallet::create([
            'user_id' => '2',
        ]);

        \App\Wallet::create([
            'user_id' => '3',
        ]);


        $teacher = \App\Teacher::create([
            'user_id' => '2',
        ]);


        $bank_information = \App\BankInformation::create([
            'user_id' => '2',
        ]);



        $user->attachRole('superadministrator');
        $user1->attachRole('user');
        $user2->attachRole('user');

        $country = \App\Country::create([
            'name_ar' => 'الكويت',
            'name_en' => 'Kuwait',
            'code' => '00965',
            'currency' => 'KWD',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'shipping'=> '5',

        ]);

        $country = \App\Country::create(        [
            'name_ar' => 'مصر',
            'name_en' => 'Egypt',
            'code' => '002',
            'currency' => 'EGP',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'shipping'=> '30',
        ]);




        $learning_system = \App\LearningSystem::create([
            'name_ar' => 'التعليم الاساسي',
            'name_en' => 'basic learning',
            'description_ar' => 'التعليم الاساسي',
            'description_en' => 'basic learning',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'country_id' => '1',
        ]);

        $learning_system = \App\LearningSystem::create([
            'name_ar' => 'التعليم الاساسي',
            'name_en' => 'basic learning',
            'description_ar' => 'التعليم الاساسي',
            'description_en' => 'basic learning',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'country_id' => '2',
        ]);




        $stage = \App\Stage::create([
            'name_ar' => 'المرحلة الابتدائية',
            'name_en' => 'Primary School',
            'learning_system_id' => '1',
            'country_id' => '1',
        ]);

        $stage = \App\Stage::create([
            'name_ar' => 'المرحلة المتوسطة',
            'name_en' => 'Primary School',
            'learning_system_id' => '1',
            'country_id' => '1',
        ]);

        $stage = \App\Stage::create([
            'name_ar' => 'المرحلة الابتدائية',
            'name_en' => 'Primary School',
            'learning_system_id' => '2',
            'country_id' => '2',
        ]);


        $ed_class = \App\EdClass::create([
            'name_ar' => 'الصف الأول الابتدائي',
            'name_en' => 'primary one',
            'stage_id' => '1',
            'country_id' => '1',
        ]);

        $ed_class = \App\EdClass::create([
            'name_ar' => 'الصف الثاني الابتدائي',
            'name_en' => 'primary one',
            'stage_id' => '1',
            'country_id' => '1',
        ]);

        $ed_class = \App\EdClass::create([
            'name_ar' => 'الصف الثاني المتوسط',
            'name_en' => 'primary one',
            'stage_id' => '2',
            'country_id' => '1',
        ]);

        $ed_class = \App\EdClass::create([
            'name_ar' => 'الصف الاول المتوسط',
            'name_en' => 'primary one',
            'stage_id' => '2',
            'country_id' => '1',
        ]);



        $ed_class = \App\EdClass::create([
            'name_ar' => 'الصف الأول الابتدائي',
            'name_en' => 'primary one',
            'stage_id' => '2',
            'country_id' => '2',
        ]);

        $course = \App\Course::create([
            'name_ar' => ' مادة الرياضايت',
            'name_en' => 'math',
            'description_ar' => ' مادة الرياضايت',
            'description_en' => 'math',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'country_id' => '1',
            'ed_class_id' => '1',
            'homework_price' => 5,
            'teacher_commission' => 3,
            'course_price' => 30,

        ]);

        $course1 = \App\Course::create([
            'name_ar' => ' مادة العلوم',
            'name_en' => 'math',
            'description_ar' => ' مادة الرياضايت',
            'description_en' => 'math',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'country_id' => '1',
            'ed_class_id' => '1',
            'homework_price' => 5,
            'teacher_commission' => 3,
            'course_price' => 30,

        ]);

        $course2 = \App\Course::create([
            'name_ar' => ' مادة العربي',
            'name_en' => 'math',
            'description_ar' => ' مادة الرياضايت',
            'description_en' => 'math',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'country_id' => '1',
            'ed_class_id' => '1',
            'homework_price' => 5,
            'teacher_commission' => 3,
            'course_price' => 30,

        ]);

        $course3 = \App\Course::create([
            'name_ar' => ' مادة الرياضايت',
            'name_en' => 'math',
            'description_ar' => ' مادة الرياضايت',
            'description_en' => 'math',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'country_id' => '1',
            'ed_class_id' => '2',
            'homework_price' => 5,
            'teacher_commission' => 3,
            'course_price' => 30,

        ]);

        $course4 = \App\Course::create([
            'name_ar' => ' مادة العلوم',
            'name_en' => 'math',
            'description_ar' => ' مادة الرياضايت',
            'description_en' => 'math',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'country_id' => '1',
            'ed_class_id' => '2',
            'homework_price' => 5,
            'teacher_commission' => 3,
            'course_price' => 30,

        ]);

        $course5 = \App\Course::create([
            'name_ar' => ' مادة العربي',
            'name_en' => 'math',
            'description_ar' => ' مادة الرياضايت',
            'description_en' => 'math',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'country_id' => '1',
            'ed_class_id' => '2',
            'homework_price' => 5,
            'teacher_commission' => 3,
            'course_price' => 30,

        ]);

        $course6 = \App\Course::create([
            'name_ar' => ' مادة الرياضايت',
            'name_en' => 'math',
            'description_ar' => ' مادة الرياضايت',
            'description_en' => 'math',
            'image' => 'images/countries/dSroDy5KlCP8nU4H5eowlWxDuabJrVrBx47Jrdkf.png',
            'country_id' => '2',
            'ed_class_id' => '2',
            'homework_price' => 5,
            'teacher_commission' => 3,
            'course_price' => 30,

        ]);

        \App\Exam::create([
            'course_id' => $course->id,
        ]);
        \App\Exam::create([
            'course_id' => $course1->id,
        ]);
        \App\Exam::create([
            'course_id' => $course2->id,
        ]);
        \App\Exam::create([
            'course_id' => $course3->id,
        ]);
        \App\Exam::create([
            'course_id' => $course4->id,
        ]);
        \App\Exam::create([
            'course_id' => $course5->id,
        ]);
        \App\Exam::create([
            'course_id' => $course6->id,
        ]);

        $chapter = \App\Chapter::create([
            'name_ar' => 'القسم الأول',
            'name_en' => 'chapter one',
            'course_id' => '1',
            'country_id' => '1',
        ]);

        $chapter = \App\Chapter::create([
            'name_ar' => 'القسم الأول',
            'name_en' => 'chapter one',
            'course_id' => '2',
            'country_id' => '2',
        ]);

    }
}
