<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    protected static ?string $password;

    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('coins')->insert([
            [
                'id'=>1,
                'name'=>'Metical',
                'symbol'=>'MZN',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>2,
                'name'=>'Dollar',
                'symbol'=>'USD',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        DB::table('roles')->insert([
            [
                'id'=>1,
                'name'=>'ADMIN',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>2,
                'name'=>'OWNER',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>3,
                'name'=>'USER',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        DB::table('prices')->insert([
            [
                'id'=>1,
                'name'=>'Normal',
                'price'=>750,
                'coin_id'=>1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>2,
                'name'=>'Horário Nobre',
                'price'=>850,
                'coin_id'=>1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        DB::table('statuses')->insert([
            [
                'id'=>1,
                'name'=>'Livre',
                'color'=>'96E9C6',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>2,
                'name'=>'Agendado',
                'color'=>'FFBB64',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>3,
                'name'=>'Cheio',
                'color'=>'D04848',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        DB::table('genders')->insert([
            [
                'id'=>1,
                'name'=>'Masculino',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>2,
                'name'=>'Feminino',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        DB::table('users')->insert([
            [
                'id'=>1,
                'name'=>'Admin',
                'surname'=>'Geral',
                'mobile'=>'842648618',
                'birth_date'=>'1997/09/18',
                'gender_id'=>1,
                'role_id'=>1,
                'email'=>'admin@test.com',
                'password'=>static::$password ??= Hash::make('password'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>2,
                'name'=>'User',
                'surname'=>'Club Owner',
                'mobile'=>'842648617',
                'birth_date'=>'1998/09/18',
                'gender_id'=>1,
                'role_id'=>2,
                'email'=>'owner@test.com',
                'password'=>static::$password ??= Hash::make('password'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>3,
                'name'=>'User',
                'surname'=>'Normal',
                'mobile'=>'842648617',
                'birth_date'=>'1998/09/18',
                'gender_id'=>1,
                'role_id'=>3,
                'email'=>'user@test.com',
                'password'=>static::$password ??= Hash::make('password'),
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);
        
        

        DB::table('clubs')->insert([
            [
                'id'=>1,
                'name'=>'Club Padel Beira',
                'image_url'=>'https://images.pexels.com/photos/2486168/pexels-photo-2486168.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'user_id'=>'2',
                'description'=>'Club de Padel da cidade da Beira',
                'address'=>'Rua do Estoril',
                'province_id'=>'1',
                'min_price'=>'600.00',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        DB::table('courts')->insert([
            [
                'id'=>1,
                'name'=>'Quadra 1',
                'image_url'=>'https://images.pexels.com/photos/2486168/pexels-photo-2486168.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'limit'=>'4',
                'club_id'=>'1',
                'description'=>'Quadra de jogo de padel 1',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>2,
                'name'=>'Quadra 2',
                'image_url'=>'https://images.pexels.com/photos/2486168/pexels-photo-2486168.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'limit'=>'4',
                'club_id'=>'1',
                'description'=>'Quadra de jogo de padel 2',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>3,
                'name'=>'Quadra 3',
                'image_url'=>'https://images.pexels.com/photos/2486168/pexels-photo-2486168.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'limit'=>'4',
                'club_id'=>'1',
                'description'=>'Quadra de jogo de padel 3',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>4,
                'name'=>'Quadra 4',
                'image_url'=>'https://images.pexels.com/photos/2486168/pexels-photo-2486168.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
                'limit'=>'4',
                'club_id'=>'1',
                'description'=>'Quadra de jogo de padel 4',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        DB::table('schedules')->insert([
            [
                'id'=>1,
                'date'=>'2024/01/31',
                'start_time'=>'09:00:00',
                'end_time'=>'10:00:00',
                'court_id'=> 1,
                'price_id'=> 1,
                'status_id'=> 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>2,
                'date'=>'2024/01/31',
                'start_time'=>'10:00:00',
                'end_time'=>'11:00:00',
                'court_id'=> 1,
                'price_id'=> 1,
                'status_id'=> 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>3,
                'date'=>'2024/01/31',
                'start_time'=>'11:00:00',
                'end_time'=>'12:00:00',
                'court_id'=> 1,
                'price_id'=> 1,
                'status_id'=> 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>4,
                'date'=>'2024/01/31',
                'start_time'=>'12:00:00',
                'end_time'=>'13:00:00',
                'court_id'=> 1,
                'price_id'=> 1,
                'status_id'=> 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>5,
                'date'=>'2024/01/31',
                'start_time'=>'13:00:00',
                'end_time'=>'14:00:00',
                'court_id'=> 1,
                'price_id'=> 1,
                'status_id'=> 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>6,
                'date'=>'2024/01/31',
                'start_time'=>'14:00:00',
                'end_time'=>'15:00:00',
                'court_id'=> 1,
                'price_id'=> 1,
                'status_id'=> 1,
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        DB::table('provinces')->insert([
            [
                'id' =>1,
                'name' => 'Maputo Cidade',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>2,
                'name' => 'Maputo Província',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>3,
                'name' => 'Inhambane',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>4,
                'name' => 'Gaza',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>5,
                'name' => 'Sofala',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>6,
                'name' => 'Manica',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>7,
                'name' => 'Tete',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>8,
                'name' => 'Zambézia',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>9,
                'name' => 'Nampula',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>10,
                'name' => 'Cabo Delgado',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id' =>11,
                'name' => 'Niassa',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
           ]);

           DB::table('type_transactions')->insert([
            [
                'id'=>1,
                'name'=>'Compra',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>2,
                'name'=>'Recarga',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'id'=>3,
                'name'=>'Devolução',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

    }
}
