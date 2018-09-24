<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicator extends Model
{
    use FullTextSearch;

    protected $fillable = [
    "name","sparepart_id","productionline_id"
  ];

  protected $searchable = [
        'name'
    ];

    public function productionLine()
    {
        return $this->belongsTo('App\ProductionLine','productionline_id');
    }

    public function mainPart()
    {
        return $this->belongsTo('App\SparePart','sparepart_id');
    }

    public function spareParts()
    {
        return $this->belongsToMany('App\SparePart','applicator_sparepart','applicator_id','sparepart_id')->withpivot('quantity','sparepart_pn');
    }

    public function delete()
    {

        // delete prodlines
        // $this->productionLines()->each(function($productionLines){$productionLines->removerelation();});
        // delete spareParts
        // $this->spareParts()->each(function($spareParts){$spareParts->delete();});

        // delete the machine
        return parent::delete();
    }
}
