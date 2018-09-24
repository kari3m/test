<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use FullTextSearch;
    protected $fillable = [
    "name","address","contact_phone","contact_email"
  ];

  protected $searchable = [
        'name','contact_phone','contact_email',
    ];

    public function plants()
    {
        return $this->hasMany('App\Plant');
    }

    public function contacts()
    {
        return $this->hasManyThrough('App\Contact', 'App\Plant','company_id','plant_id','id','id');
    }

    public function productionLines()
    {
        return $this->hasManyThrough('App\ProductionLine', 'App\Plant','company_id','plant_id','id','id');
    }

  public function delete()
    {
        // delete all related plants
        $this->plants()->each(function($plants){$plants->delete();});



        // delete the company
        return parent::delete();
    }
}
