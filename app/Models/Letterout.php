<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letterout extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_no',
        'letterout_date',
        'first_number',
        'temp_number',
        'regarding',
        'purpose',
        'attribute',
        'copy',
        'content',
        'letter_file',
        'letter_type'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $date_letter = $model->letterout_date ?: now();
            if (is_string($date_letter)) {
                $date_letter = Carbon::parse($date_letter);
            }
            $model->first_number = $date_letter->format('dmy');

            $model->temp_number = static::count() + 1;
        });
    }

    protected $hidden = [];
}
