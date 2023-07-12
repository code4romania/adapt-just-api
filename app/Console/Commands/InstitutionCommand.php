<?php

namespace App\Console\Commands;

use App\Constants\PermissionConstant;
use App\Models\Institution;
use App\Models\Location;
use App\Models\Permission;
use Illuminate\Console\Command;

class InstitutionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'institution:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update institutions list';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $institutions = json_decode(file_get_contents(__DIR__ . '/../../../database/dumps/institutions.json'), true);
        foreach ($institutions as $sheetName => $sheet) {
            foreach ($sheet as $ind => $item) {
                $this->parseData($item);
            }

        }
    }

    protected function parseData($institution)
    {
        if (isset($institution["Adresa de email institutie (email1; email2; etc)"])) {
            $emails = explode(";", $institution["Adresa de email institutie (email1; email2; etc)"]);
            foreach ($emails as $i => $email) {
                $emails[$i] = trim($email);
            }
            $emails = array_filter($emails);
            $countyIso = (!empty($institution['COD ISO Judet']) && trim($institution['COD ISO Judet']) != "-") ? $institution['COD ISO Judet'] : NULL;
            $countyName = (!empty($institution['Nume judet']) && trim($institution['Nume judet']) != "-") ? $institution['Nume judet'] : NULL;
            $data = [
                "type" => $institution['Tip institutie'],
                "name" => $institution['Denumire Institutie'],
                "email" => $emails,
                "county_iso" => $countyIso,
                "county_name" => $countyName
            ];
            Institution::query()->updateOrCreate(
                [
                    'type' => $data['type'],
                    'name' => $data['name'],
                    'county_iso' => $data['county_iso']
                ],
                $data
            );
        }

    }


}
