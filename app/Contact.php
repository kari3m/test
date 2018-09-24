<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  use FullTextSearch;
    protected $fillable = [
    "name","phone","email","address","position","company_id","plant_id"
  ];
  protected $searchable = [
        'name','phone','email'
    ];

    public function plant()
    {
        return $this->belongsTo('App\Plant');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
