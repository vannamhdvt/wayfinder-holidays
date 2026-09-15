<?php

namespace App\Models;

use App\Enums\EnquiryStatus;
use Illuminate\Database\Eloquent\Model;

class TourEnquiry extends Model
{
    protected $table = 'tour_enquiries';
    protected $fillable = [
        'tour_id',
        'name',
        'email',
        'phone',
        'preferred_month',
        'message',
    ];

    protected function casts(): array
    {
        return [
            'status' => EnquiryStatus::class,
        ];
    }

    public function tour() {
        return $this->belongsTo(Tour::class);
    }
}
