<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
  use FullTextSearch;
    protected $fillable = [
    "name","location","company_id"
  ];
  protected $searchable = [
        'name',
    ];
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function productionLines()
    {
        return $this->hasMany('App\ProductionLine');
    }

    // public function Contacts()
    // {
    //     return $this->hasMany('App\Contact');
    // }

    public function delete()
    {
        // delete all related contacts
        $this->contacts()->delete();

        // delete productionlines
        $this->productionLines()->each(function($productionLines){$productionLines->delete();});

        // delete the plant
        return parent::delete();
    }
}
