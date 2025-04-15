<?php

        namespace Database\Seeders;

        use App\Models\User;
        // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
        use Illuminate\Database\Seeder;

        class DatabaseSeeder extends Seeder
        {
            /**
             * Seed the application's database.
             */
            public function run(): void
            {
                // User::factory(10)->create();
                $userData = [
                    [
                        'name' => 'employe',
                        'email' => 'employe@gmail.com',
                        'role' => 'employe',
                        'password' =>bcrypt('1234'),
                    ],
                    [
                        'name' => 'admin',
                        'email' => 'admin@gmail.com',
                        'role' => 'admin',
                        'password' =>bcrypt('1234'),
                    ]
                ];
                foreach($userData as $key => $val){
                    User::create($val);
                }
            }
        }
