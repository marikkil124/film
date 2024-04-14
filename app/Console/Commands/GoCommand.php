<?php

namespace App\Console\Commands;

use App\Events\baba;
use App\Models\Film;
use App\Models\Genre;
use App\Models\ProductUser;
use App\Models\User;
use App\Models\Profile;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        $genre = Genre::first();
//        $film = Film::where('id',6)->get();
//        $user = User::first();
//        dd($user->is_admin);


        dd(env('app_url'));

//        User::create([
//            'name' => 'runli',
//            'email' => 'runli@mail.ru',
//            'password' => Hash::make('123123'),
//
//        ]);

       // dd($user->profile->nickname);
        //dd($film->genre->toarray());

    }
}
