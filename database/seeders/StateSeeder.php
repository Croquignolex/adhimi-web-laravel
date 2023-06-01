<?php

namespace Database\Seeders;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Storage;
use App\Enums\GeneralStatusEnum;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $output = new ConsoleOutput();

        if (Storage::disk('local')->exists('countries-states.json')) {
            $fileJsonContent = Storage::disk('local')->get('countries-states.json');
            $fileJsonDecoded = json_decode($fileJsonContent, true, 512, JSON_THROW_ON_ERROR);

            foreach ($fileJsonDecoded as $country) {
                $dbCountry = Country::whereName($country['name'])->first();

                if ($dbCountry instanceof Country) {
                    foreach ($country['states'] as $state) {
                        State::factory()->for($dbCountry)->create([
                            'latitude' => $state['latitude'],
                            'longitude' => $state['longitude'],
                            'name' => $state['name'],
                            'status' => GeneralStatusEnum::Enable,
                        ]);
                    }
                } else {
                    $output->writeln('<error>Country "' . $country['name'] . '" with code iso "' . $country['iso2'] . '" not found</error>');
                }
            }
        } else {
            $output->writeln('<info>States file not found</info>');
            $output->writeln('<info>Please Go to https://github.com/dr5hn/countries-states-cities-database and download the file : countries+states.json</info>');
            $output->writeln('<info>Put it in storage/app folder and rename it "countries-states.json"</info>');
        }
    }
}
