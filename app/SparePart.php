<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
   use FullTextSearch;
    protected $fillable = [
    "pn","description","ded_price","ger_price","quick_reference","deleted"
  ];
  protected $searchable = [
        'pn','quick_reference'
    ];
    public function machines()
    {
        return $this->belongsToMany('App\Machine','machine_sparepart','sparepart_id','machine_id')->withpivot('quantity','sparepart_pn');
    }

    public function applicators()
    {
        return $this->belongsToMany('App\Applicator','applicator_sparepart','sparepart_id','applicator_id')->withpivot('quantity','sparepart_pn');
    }

    public function productionlines()
    {
        return $this->belongsToMany('App\ProductionLine','productionline_sparepart','sparepart_id','productionline_id')->withpivot('S_N');
    }

    // public function parent()
    // {
    //     return $this->belongsTo('App\SparePart','parent_id');
    // }

    public function children()
    {
        return $this->belongsToMany('App\SparePart','sparepart_sparepart','parent_id','child_id')->withpivot('quantity');
    }
    public function machine()
    {
        return $this->hasMany('App\Machine','sparepart_pn');
    }

    public function applicator()
    {
        return $this->hasMany('App\Applicator','sparepart_pn');
    }

    public function delete()
    {

        // $this->children()->each(function($children){$children->delete();});
        // $this->children()->each(function($children){$children->delete();});
        return parent::delete();
    }

  //   public function deleteAll() {
  //     $part = self::find($this->id);
  //     $part->update([
  //         'parent_id' => false
  //     ]);
  //
  //     //delete children, either hard or soft (use foreach loop on soft)
  //     $part->types()->delete();
  // }


    // public function deleteAll() {
    // $SparePart = self::find($this->id);
    // $SparePart->update([
    //     'parent' => false
    // ]);

    //delete children, either hard or soft (use foreach loop on soft)
    // $campaign->types()->delete();}
}
