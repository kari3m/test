<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Applicator;
use App\SparePart;


class ApplicatorController extends Controller
{
    public function index()
    {
      $applicators = Applicator::with('mainPart','productionLine')->get();
      return response()->json($applicators);
    }

    public function addapplicatortoline(Request $request)
    {
        $applicator = Applicator::findOrFail($request->id)->update(['productionline_id' => $request->productionline_id]);
        // $applicator->save();
        return response()->json("updated");
    }

    public function applicatorparts($id)
    {
        $parts = DB::table('applicator_sparepart')
                     ->join('spare_parts', 'spare_parts.id', '=', 'sparepart_id')
                     ->select('sparepart_id as id','sparepart_pn','quantity')
                     ->where('applicator_id', '=', $id)
                     ->get();
        return response()->json($parts);
    }


    public function show($id)
    {
        $applicator = Applicator::where("id",$id)->first()->mainPart()->get();
        return response()->json($applicator);
    }


    public function store(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30',
            'sparepart_id' => 'required'
        ]);
        Applicator::create([
            'name' => request ('name'),
            'sparepart_id' => request ('sparepart_id'),
            'productionline_id' => request('productionline_id')
        ]);
        return response()->json(['message' => 'Applicator Added']);
    }
    public function search($word){
      $applicators = Applicator::search($word)->get();
      return response()->json($applicators);
    }

    public function edit(Request $request)
    {

        $this->validate(request(),[
            'name' => 'required|max:30'
        ]);
        $applicator = Applicator::findOrFail($request->id);
        $applicator->name = $request->name;
        $applicator->sparepart_id = $request->sparepart_id;
        $applicator->productionline_id = $request->productionline_id;
        $applicator->save();

        return response()->json(['message' => 'Applicator Edited']);
    }

    

    public function editoneapplicatorpart(Request $request)
    {
        $applicator = Applicator::findOrFail($request->applicator_id);
        $applicator->spareParts()
        ->newPivotStatement()
        ->where('sparepart_id', $request->id)
        ->update(['quantity' => $request->quantity]);


        return response()->json(['message' => 'Applicator Edited']);
    }

    public function delete($id)
    {
        $applicator = Applicator::findOrFail($id);
        $applicator->spareParts()->detach();
        $applicator->delete();
        return response()->json(['message' => 'Applicator Deleted']);
    }

 

    public function detachoneapplicatorpart($part,$applicator)
    {
      $parts = Applicator::findOrFail($applicator)->spareParts()
              ->wherePivot('sparepart_id', '=', $part)->detach();

        return response()->json("detached successfully");
    }

public function editt(Request $request)
  {
      return response()->json($request);

      $this->validate(request(),[
          'name' => 'required|max:30'
      ]);
      $part = SparePart::findOrFail($request->id);
      $part->pn = $request->pn;

      $part->save();

      return response()->json(['message' => 'Part Edited']);
  }

  public function delette($id)
  {
      $part = SparePart::findOrFail($id);
      $part->applicators()->detach();
      $part->delete();
      return response()->json(['message' => 'Part Deleted']);
  }
}
