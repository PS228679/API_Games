<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Voeg test functies toe en bewaar deze in variabele zodat je er bij de 
        // testwerknemers aan kunt verwijzen.
        $nintendo = Developer::create(['naam' => 'Nintendo']);
        $insomniac = Developer::create(['naam' => 'Insomniac',]);
        $monolith_soft = Developer::create(['naam' => 'monolith_soft',]);
        $sonic_team = Developer::create(['naam' => 'sonic_team',]);
        

        // Voeg test werknemers toe. Maak gebruik van de testfuncties die je hiervoor in
        // variabelen hebt bewaard. NB: De testwerknemers heb je hier niet meer nodig, dus 
        // je hoeft ze niet in een variabele te bewaren

        Game::create([
            'naam' => 'Super Mario Maker 2',
            'dev_id' => $nintendo->id,
            'release_date' => '2019-06-28', 
            'platform' => 'Nintendo Switch'
        ]);

        Game::create([
            'naam' => 'Spider-Man Remastered',
            'dev_id' => $insomniac->id,
            'release_date' => '2022-08-12', 
            'platform' => 'PS5'
        ]);

        Game::create([
            'naam' => 'Xenoblade Chronicles 2',
            'dev_id' => $monolith_soft->id,
            'release_date' => '2017-12-01', 
            'platform' => 'Nintendo Switch'
        ]);

        Game::create([
            'naam' => 'Sonic Unleashed',
            'dev_id' => $sonic_team->id,
            'release_date' => '2008-11-18', 
            'platform' => 'Xbox 360, PS3, Wii, PS2'
        ]);
    }
}