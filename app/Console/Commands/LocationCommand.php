<?php

namespace App\Console\Commands;

use App\Constants\PermissionConstant;
use App\Models\Location;
use App\Models\Permission;
use Illuminate\Console\Command;

class LocationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update locations list';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $locations = json_decode(file_get_contents(__DIR__ . '/../../../database/dumps/spitale.json'), true);
        foreach ($locations as $location) {
            $this->parseData($location);
        }

        $locations = json_decode(file_get_contents(__DIR__ . '/../../../database/dumps/centre-copii.json'), true);
        foreach ($locations as $location) {
            $this->parseData($location);
        }

        $locations = json_decode(file_get_contents(__DIR__ . '/../../../database/dumps/centre-adulti.json'), true);
        foreach ($locations as $location) {
            $this->parseData($location);
        }

    }

    protected function parseData($location)
    {
        $data = [
            "type" => $location['Tip institutie'],
            "name" => $this->removeSpecialCharacters($location['Denumire Institutie']),
            "label" => $location['Denumire Institutie'],
            "email" => "",
            "county_iso" => $location['COD ISO Judet'],
            "county_name" => $this->removeSpecialCharacters($location['Nume judet']),
            "county_label" => $location['Nume judet'],
            "city_name" => $this->removeSpecialCharacters($location['Nume localitate']),
            "city_label" => $location['Nume localitate'],
            "lat" => $location["Coordonare Longitudine (optional)"] ?? '',
            "lng" => $location["Coordonate Latitudine (optional)"] ?? ''
        ];
        Location::query()->updateOrCreate(['name' => $data['name'], 'county_iso' => $data['county_iso']], $data);
    }

    protected function removeSpecialCharacters($string)
    {
        $ro_in = array("\xC4\x82", "\xC4\x83", "\xC3\x82", "\xC3\xA2", "\xC3\x8E", "\xC3\xAE", "\xC8\x98", "\xC8\x99", "\xC8\x9A", "\xC8\x9B", "\xC5\x9E", "\xC5\x9F", "\xC5\xA2", "\xC5\xA3");
        $ro_out = array('A', 'a', 'A', 'a', 'I', 'i', 'S', 's', 'T', 't', 'S', 's', 'T', 't');

        $search = array_merge($ro_in);
        $replace = array_merge($ro_out);
        $string = str_replace($search, $replace, $string);

        return $string;
    }

}
