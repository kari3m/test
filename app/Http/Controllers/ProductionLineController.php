<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ProductionLine;
use App\SparePart;


class ProductionLineController extends Controller
{
	public function index()
	{
		$plines = ProductionLine::with('plant','company')->get();
	 	return response()->json($plines);
	}

    public function productionlineparts($id)
    {
        // $parts = ProductionLine::where("id",$id)->first()->spareParts()->with('parent')->get();
        $parts = DB::table('productionline_sparepart')
                     ->join('spare_parts', 'spare_parts.id', '=', 'sparepart_id')
                     ->select('sparepart_id','spare_parts.pn', DB::raw('count(*) as quantity'))
                     ->where('productionline_id', '=', $id)
                     ->groupBy('sparepart_id','spare_parts.pn')
                     ->get();
        return response()->json($parts);
    }

    public function productionlinemelters($id)
    {
        $melters = DB::table('melter_productionline')
                     ->join('machines', 'machines.id', '=', 'melter_id')
                     ->select('melter_id','machines.name', DB::raw('count(*) as quantity'))
                     ->where('productionline_id', '=', $id)
                     ->groupBy('melter_id','machines.name')
                     ->get();
        return response()->json($melters);
    }

    public function productionlineapplicators($id)
    {
        // $parts = ProductionLine::where("id",$id)->first()->spareParts()->with('parent')->get();
        $applicators = ProductionLine::findOrFail($id)->applicators()->get();
        return response()->json($applicators);
    }
    public function productionlineallmeltersserials($line)
    {
        $parts = ProductionLine::findOrFail($line)->melters()
                ->select('S_N')->get();

        return response()->json($parts);
    }

    public function productionlinepartserials($part,$line)
    {
      
        $parts = ProductionLine::findOrFail($line)->spareParts()
                ->wherePivot('sparepart_id', '=', $part)->get();
      
      
        return response()->json($parts);
    }

    public function productionlineallpartsserials($line)
    {
        $parts = ProductionLine::findOrFail($line)->spareParts()
                ->select('S_N')->get();

        return response()->json($parts);
    }

    public function productionlinemelterserials($melter,$line)
    {
      $melters = ProductionLine::findOrFail($line)->melters()
              ->wherePivot('melter_id', '=', $melter)->get();
      
        return response()->json($melters);
    }

    public function store(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30',
            'company_id' => 'required',
            'plant_id' => 'required'
        ]);
        ProductionLine::create([
            'name' => request ('name'),
            'company_id' => request ('company_id'),
            'plant_id' => request ('plant_id')
        ]);
        return response()->json(['message' => 'Production line Added']);
    }

    public function edit(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30',
            'company_id' => 'required',
            'plant_id' => 'required'
        ]);
        $pline = ProductionLine::findOrFail($request->id);
        $pline->name = $request->name;
        $pline->company_id = $request->company_id;
        $pline->plant_id = $request->plant_id;

        $pline->save();

        return response()->json(['message' => 'Production line Edited']);
    }

    public function editproductionlineparts(Request $request)
    {
        $pline = ProductionLine::findOrFail($request->productionline_id);
        
          $pline->spareParts()
          ->newPivotStatement()
          ->where([
                ['sparepart_id', '=', $request->id]
                ])
          ->update([
                'quantity' => $request->quantity 
               
            ]);
        
        

        return response()->json(['message' => 'Production line parts Edited']);
    }

    public function editoneproductionlinepart(Request $request,$oldsn)
    {
        $pline = ProductionLine::findOrFail($request->productionline_id);
        $pline->spareParts()
        ->newPivotStatement()
        ->where([
              ['sparepart_id', '=', $request->id],
              ['S_N', '=', $oldsn]])
        ->update([
                       
              'S_N' => $request->S_N
          ]);
        

        return response()->json(['message' => 'Production line part Edited']);
    }

    public function editoneproductionlinemelter(Request $request,$oldsn)
    {
        $pline = ProductionLine::findOrFail($request->productionline_id);
        $pline->melters()
        ->newPivotStatement()
        ->where([
              ['melter_id', '=', $request->id],
              ['S_N', '=', $oldsn]])
        ->update([
              'S_N' => $request->S_N
          ]);
        

        return response()->json(['message' => 'Production line part Edited']);
    }

    public function delete($id)
    {
        $pline = ProductionLine::findOrFail($id);
        $pline->spareParts()->detach();
        $pline->melters()->detach();
        $pline->applicators()->delete();
        $pline->delete();
        return response()->json(['message' => 'Production line Deleted']);
    }

    // public function detachproductionlineapplicator($applicator,$line,)
    // {
    //   if($parent == 'null'){
    //     $applicators = ProductionLine::findOrFail($line)->applicators()
    //             ->wherePivot('applicator_id', '=', $applicator)
    //             ->wherePivot('parent_id', null)->detach();
    //   }
    //   else{
    //     $applicators = ProductionLine::findOrFail($line)->applicators()
    //             ->wherePivot('applicator_id', '=', $applicator)
    //             ->wherePivot('parent_id', '=', $parent)->detach();
    //   }
      
    //     return response()->json("detached successfully");
    // }

    public function detachoneproductionlineapplicator($applicator,$line)
    {
      $applicators = ProductionLine::findOrFail($line)->applicators()
              ->where('id', '=', $applicator)
              ->delete();
      
        return response()->json("detached successfully");
    }

    public function detachproductionlinepart($part,$line)
    {
     
        $parts = ProductionLine::findOrFail($line)->spareParts()
                ->wherePivot('sparepart_id', '=', $part)
                ->detach();
      
      
        return response()->json("detached successfully");
    }

    public function detachoneproductionlinepart($part,$line,$serial)
    {
      $parts = ProductionLine::findOrFail($line)->spareParts()
              ->wherePivot('sparepart_id', '=', $part)
              ->wherePivot('S_N', '=', $serial)->detach();
      
        return response()->json("detached successfully");
    }

    public function detachproductionlinemelter($melter,$line)
    {
     
        $melters = ProductionLine::findOrFail($line)->melters()
                ->wherePivot('melter_id', '=', $melter)
                ->detach();
      
      
        return response()->json("detached successfully");
    }

    public function detachoneproductionlinemelter($melter,$line,$serial)
    {
      $melters = ProductionLine::findOrFail($line)->melters()
              ->wherePivot('melter_id', '=', $melter)
              ->wherePivot('S_N', '=', $serial)->detach();
      
        return response()->json("detached successfully");
    }
		public function search($word){
			$plines = ProductionLine::search($word)->with('plant','company')->get();
			return response()->json($plines);
		}


}
