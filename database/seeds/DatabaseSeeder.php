<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Role;
use App\Pet;
use App\Project;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();
        DB::table('roles')->delete();
        DB::table('role_user')->delete();

        $adminUser = factory(\App\User::class)->states('admin')->create();
        $normalUser = factory(\App\User::class)->states('normal')->create();
        factory(\App\User::class, 5)->create();
        factory(\App\Task::class, 3)->create();

        factory(\App\Project::class)->create()
            ->tasks()->saveMany(factory(\App\Task::class, 2)->states('no-project')->make());

        factory(\App\Project::class)->create()
            ->tasks()->saveMany(factory(\App\Task::class, 5)->states('no-project')->make());

        $role = factory(\App\Role::class)->states('admin')->create();

        $adminUser->roles()->attach($role->id);

        $pets = [
            [ 'name' => 'Bingo', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Natasha', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Bela', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Doug', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Charlote', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Negão', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Fani', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Brisa', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Alemão', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Lenny', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Lord', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Leka', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Lampião', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Lana', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Lassie', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Reiki', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Recruta', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Rabito', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Rocco', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Rush', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Ice', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Grandão', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Gold', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Guidi', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Guyzza', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Eagle', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Estopa', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Estopim', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Bomba', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Velhinho', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Vedita', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Vidinha', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Volpi', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Vulcano', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Vocky', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Volverine', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Taison', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Maguila', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Tarzan', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Ted', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Taz', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Tank', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Thelonius', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Thabata', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Jack', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Tom', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Jade', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Juju', 'type' => 'Cachorro', 'age' => null ],
            [ 'name' => 'Baby', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Bart', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Bina', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Blue', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Belo', 'type' => 'Gato', 'age' => null ],
            [ 'name' => 'Barbie', 'type' => 'Gato', 'age' => null ]
        ];

        collect($pets)->each(function ($pet) {
            Pet::create($pet);
        });

        Model::reguard();
    }
}
