<?php

namespace App;

use App\Enums\FeedbackResultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use OwenIt\Auditing\Contracts\Auditable;

class FeedbackResult extends Model implements Auditable{

    use \OwenIt\Auditing\Auditable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'comment',
        'rates',
        'best_track',
        'status'
    ];
    protected $casts = [
        'rates' => 'array',
        'status' => FeedbackResultStatus::class
    ];

    public function feedback(){
        return $this->belongsTo(Feedback::class);
    }
}
