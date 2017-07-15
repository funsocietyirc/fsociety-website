<?php
use Fsociety\Models\Season;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initial Season Seed
        collect([
            '1' => 'Our democracy has been hacked.',
            '2' => 'Control is an illusion.',
            '3' => '',
        ])->each(function ($value, $key) {
            Season::firstOrCreate([
                'number' => $key,
                'tagline' => $value
            ]);
        });
    }
}
