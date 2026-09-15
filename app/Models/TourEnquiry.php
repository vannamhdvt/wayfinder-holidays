<?php

namespace App\Models;

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
        'status',
    ];
    public function tour() {
        return $this->belongsTo(Tour::class);
    }
}
