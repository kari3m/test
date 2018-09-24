<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use FullTextSearch;

    protected $fillable = [
    "name","sparepart_id"
  ];

  protected $searchable = [
        'name'
    ];
    public function mainPart()
    {
        return $this->belongsTo('App\SparePart','sparepart_id');
    }
    public function spareParts()
    {
        return $this->belongsToMany('App\SparePart','machine_sparepart','machine_id','sparepart_id')->withpivot('quantity','sparepart_pn');
    }

    public function productionLines()
    {
        return $this->belongsToMany('App\ProductionLine','melter_productionline','melter_id','productionline_id')->withpivot('S_N','melter_name');
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
