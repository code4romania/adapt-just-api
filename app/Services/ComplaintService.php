<?php

namespace App\Services;

use App\Constants\ComplaintConstant;
use App\Mail\ComplaintEmail;
use App\Models\Complaint;
use App\Models\Filters\DateBetweenFilter;
use App\Models\Institution;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ComplaintService
{
    public static function complaints($perPage = 10): LengthAwarePaginator
    {
        return QueryBuilder::for(Complaint::class)
            ->allowedSorts(['id', 'created_at', 'name', 'city'])
            ->allowedFilters([
                AllowedFilter::custom('created_at', new DateBetweenFilter),
                'name',
                'city_name',
                'location_name',
                'type'
            ])
            ->paginate($perPage);
    }

    public static function create($data): Model|Builder
    {
        $data['id_card_upload_id'] = $data['id_card_upload']['id'] ?? null;
        $complaint = Complaint::query()->create($data);

        $uploads = Arr::pluck(Arr::get($data, 'uploads', []), 'id');
        $complaint->uploads()->sync($uploads);

        foreach ($complaint->uploads as $upload) {
            UploadService::setUploadPath($upload, 'complaints/'.$complaint->id);
        }

        if (!empty($data['signature'])) {

            $signatureBase64 = preg_replace('#^data:image/[^;]+;base64,#', '', $data['signature']);
            $signature = UploadService::uploadBase64($signatureBase64, 'complaints/'.$complaint->id);
            if ($signature) {
                $complaint->update([
                    'signature_upload_id' => $signature->id
                ]);
            }
        }

        $dataUpdate = [];
        if ($complaint->location) {
            $dataUpdate['county_iso'] = $complaint->location->county_iso;
            $dataUpdate['county_name'] = $complaint->location->county_label;
            $dataUpdate['city_label'] = $complaint->location->city_label;
        }
        if (count($dataUpdate)) {
            $complaint->update($dataUpdate);
        }
        return $complaint;
    }

    public static function update($data, $id): Model|Builder
    {
        $complaint = Complaint::find($id);
        $complaint->update($data);

        return $complaint;
    }

    public static function delete(Complaint $complaint): ?bool
    {
        return $complaint->delete();
    }

    public static function getInsititutionsDetails($victim, $type = null, $countyISO = null, $lat = null, $lng = null)
    {
        $locationIndex = $countyISO ? 'with_location' : 'without_location';
        if ($victim == ComplaintConstant::VICTIM_ME) {
            $institutionTypes = ComplaintConstant::institutionTypeList()[$victim][$type][$locationIndex];
        } else {
            $institutionTypes = ComplaintConstant::institutionTypeList()[ComplaintConstant::VICTIM_OTHER][$locationIndex];
        }

        $query = Institution::query()
            ->whereIn('type', $institutionTypes)
        ;
            $query->where(function ($q) use ($countyISO) {
                if ($countyISO) {
                    $q->where('county_iso', $countyISO);
                }
                $q->orWhereNull('county_iso');
            });

        $institutions = $query->get();


        $emails = [];
        foreach ($institutions as $institution) {
            if (is_array($institution->email)) {
                $emails = array_merge($emails, $institution->email);
            }
        }
        $emails = array_unique($emails);

        return [
            'types' => $institutionTypes,
            'emails' => $emails
        ];
    }

    public static function sendEmail($complaint)
    {
        $institutionDetails = ComplaintService::getInsititutionsDetails($complaint->victim, $complaint->type, $complaint->county_iso, $complaint->lat, $complaint->lng);
        if (config('app.env') !== "production") {
            $emailLists = [
                'miruna.muscan@code4.ro',
                'olivia.vereha@code4.ro',
                'andrei.ionita@code4.ro',
                'catalin.iacob@web-group.ro'
            ];
        } else {
            $emailLists = $institutionDetails['emails'];
        }

        if (count($emailLists)) {
            $sentTo = $emailLists[0];
            array_shift($emailLists);
            Mail::to($sentTo)
                ->cc($emailLists)
                ->send(new ComplaintEmail($complaint));

            $complaint->update([
                'sent_to_institutions' => $institutionDetails['types'],
                'sent_to_emails' => $institutionDetails['emails'],
                'sent_at' => Carbon::now()
            ]);

        }


    }
}
