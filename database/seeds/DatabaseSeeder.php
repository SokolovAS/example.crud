<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\Models\User;
use App\Models\Comment;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $faker = Faker::create();
        $art_id = 1;
        foreach (range(1,10) as $index) {
            Article::create([
                'user_id' => $faker->numberBetween(1, 5),
                'title' => $faker->sentence(6, $variableNbWords = true),
                'text' => $faker->paragraph(25, true),
                'date' => $faker->dateTimeBetween('-2 years', 'now'),
            ]);
            foreach (range(1,5) as $ind){
                Comment::create([
                    'article_id'=>$art_id,
                    'text' => $faker->paragraph(2, true),
                    'email' => $faker->email,
                    'date' => $faker->dateTimeBetween('-2 years', 'now'),
                ]);
            }
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('123456'),
            ]);
            $art_id++;
        }

        $user = User::create([
            'name' => $faker->name,
            'email' =>  'admin1@example.com',
            'password' => bcrypt('demo123'),
        ]);

        $roleModerator = Role::create([
            'name' => 'Moderator',
            'slug' => 'moderator',
            'level' => 2,
        ]);

        $permDeleteAll = Permission::create([
            'name' => 'Delete all',
            'slug' => 'delete.all',
            ]);

        $permUpdateAll = Permission::create([
            'name' => 'Update all',
            'slug' => 'update.all',
            ]);

        $user->attachRole($roleModerator);
        $user->attachPermission($permDeleteAll);
        $user->attachPermission($permUpdateAll);

        $user = User::create([
            'name' => $faker->name,
            'email' =>  'admin2@example.com',
            'password' => bcrypt('demo123'),
        ]);

        $user->attachRole($roleModerator);
        $user->attachPermission($permDeleteAll);
        $user->attachPermission($permUpdateAll);

    }
}
