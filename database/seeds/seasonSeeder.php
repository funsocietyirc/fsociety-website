<?php
use fsociety\Season;
use Illuminate\Database\Seeder;


class seasonSeeder extends Seeder
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
        ])->each(function ($value, $key) {
            Season::firstOrCreate([
                'number' => $key,
                'tagline' => $value
            ]);
        });
    }
}
