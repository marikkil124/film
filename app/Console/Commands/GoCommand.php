<?php

namespace App\Console\Commands;

use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use App\Models\Profile;

use Illuminate\Console\Command;

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
        $genre = Genre::first();
        $film = Film::where('id',6)->get();
        $user = User::first();
        dd($film);
        dd($film->genre);


       // dd($user->profile->nickname);
        //dd($film->genre->toarray());

    }
}
