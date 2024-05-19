<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;
    protected $fillable = [
        'letter_id',
        'lampiran',
        'status',
        'sifat',
        'petunjuk',
        'catatan_rektor',
        'tgl_selesai',
        'kepada',
        'petunjuk_kpd_1',
        'tgl_selesai_2',
        'penerima_2',
        'check_status',
        'letter_file'
    ];
    // protected $dates = ['tgl_selesai','tgl_aju_kembali','tgl_selesai_2','tgl_selesai_3'];
    protected $hidden = [];

    public function letter()
    {
        return $this->belongsTo(Letter::class, 'letter_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
