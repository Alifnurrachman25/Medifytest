<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // use HasFactory;
    protected $fillable = ['nama', 'kode'];

    public function items()
    {
        return $this->belongsToMany(MasterItem::class, 'kategori_master_item');
    }
}
