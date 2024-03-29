<?php

namespace App\Models;

use App\Constants\ComplaintConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;

class Complaint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'register_number',
        'victim',
        'type',
        'name',
        'cnp',
        'location_id',
        'location_name',
        'location_to_id',
        'location_to_name',
        'location_to_type',
        'details',
        'reason',
        'proof_type',
        'lat',
        'lng',
        'county_iso',
        'county_name',
        'city_name',
        'sent_to_institutions',
        'sent_to_emails',
        'sent_at',
        'id_card_upload_id',
        'signature_upload_id'
    ];

    protected $casts = [
        'details' => 'array',
        'sent_to_institutions' => 'array',
        'sent_to_emails' => 'array',
        'sent_at' => 'datetime'
    ];


    /**
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return BelongsTo
     */
    public function locationTo(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }


    /**
     * @return BelongsToMany
     */
    public function uploads(): BelongsToMany
    {
        return $this->belongsToMany(Upload::class, 'complaint_uploads');
    }

    /**
     * @return BelongsTo
     */
    public function idCard(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'id_card_upload_id');
    }

    /**
     * @return BelongsTo
     */
    public function signature(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'signature_upload_id');
    }

    public function getDetailLabels()
    {
        $details = [];
        if (is_array($this->details) && count($this->details)) {
            foreach ($this->details as $d) {
                if ($d === ComplaintConstant::DETAIL_OTHER) {
                    $details[] = $this->reason;
                } elseif (Arr::get(ComplaintConstant::detailLabels(), $d)) {
                    $details[] = Arr::get(ComplaintConstant::detailLabels(), $d);
                }
            }
        }

        return $details;
    }

    public function getEmailSentAttribute()
    {
        return view('emails.complaint', ['complaint' => $this])->render();
    }

}
