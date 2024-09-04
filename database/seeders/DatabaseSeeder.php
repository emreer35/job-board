<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\JobAplications;
use App\Models\Joob;
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
        User::factory()->create([
            'name' =>'test',
            'email' => 'test@gmail.com'
        ]);
        User::factory(300)->create();
        // shuffle() ile kullanıcıların sırası karıştırılıyor, böylece her seferinde
        // farklı kullanıcılar atanabilir.
        $users = User::all()->shuffle();

        for ($i = 0; $i < 20; $i++) {
            Employer::factory()->create([
                // yukarida shuffle ile random bir sekilde kullanici aldik 
                // pop() metodu ise, bu karıştırılmış listeden bir kullanıcıyı alır ve
                // çıkarır, böylece aynı kullanıcı birden fazla işverene atanmaz.
                'user_id' => $users->pop()->id
            ]);
        }
        $employers = Employer::all();

        for ($i = 0; $i < 100; $i++) {
            Joob::factory()->create([
                'employer_id' => $employers->random()->id
            ]);
        }

        foreach($users as $user){
            $jobs = Joob::inRandomOrder()->take(rand(0,4))->get();

            foreach($jobs as $job){
                JobAplications::factory()->create([
                    'joob_id'=>$job->id,
                    'user_id'=>$user->id
                ]);
            }
        }

        // Joob::factory(100)->create();

        
    }
}
