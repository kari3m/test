<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionLine extends Model
{
    use FullTextSearch;
    protected $fillable = [
    'name','company_id','plant_id','sparepart_id'
  ];
  protected $searchable = [
        'name',
    ];
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function plant()
    {
        return $this->belongsTo('App\Plant');
    }

    public function delete()
    {
        // delete machines
        // $this->machines()->each(function($machines){$machines->delete();});

        // delete the production line
        return parent::delete();
    }

    public function spareParts()
    {
        return $this->belongsToMany('App\SparePart','productionline_sparepart','productionline_id','sparepart_id')->withpivot('S_N');
    }

    public function melters()
    {
        return $this->belongsToMany('App\Machine','melter_productionline','productionline_id','melter_id')->withpivot('S_N');
    }

    public function applicators()
    {
        return $this->hasMany('App\Applicator','productionline_id');
    }

}
