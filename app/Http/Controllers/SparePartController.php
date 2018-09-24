<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SparePart;
class SparePartController extends Controller
{
    public function show($id)
    {
        $part = SparePart::where("id",$id)->first();
        return response()->json($part);
    }


    public function store(Request $request)
    {

        $this->validate(request(),[
            'pn' => 'required|max:30',
         ]);
        SparePart::create([
            'pn' => request ('pn'),
            'description'=> request ('description'),
            'ded_price' => request ('ded_price'),
            'ger_price' => request ('ger_price'),
            'quick_reference' => request  ('quick_reference')
        ]);
        return response()->json(['message' => 'Part Added']);
    }

    public function storemany(Request $request,$len)
    {
      for ($i = 0; $i < $len ; $i++) {
        SparePart::create([
            'pn' => request($i)['pn'],
            'description'=> request($i)['description'],
            'ded_price' => request($i)['ded_price'],
            'ger_price' => request($i)['ger_price'],
            'quick_reference' => request($i)['quick_reference']
        ]);

      } 
        return response()->json(['message' => 'Part Added']);
    }

    public function edit(Request $request)
    {
        $this->validate(request(),[
            'pn' => 'required|max:30',
            'description' => 'required',
            'ded_price' => 'required',
            'ger_price' => 'required',
            'quick_reference' => 'required'
            // 'parent_id' => 'required'
        ]);
        $part = SparePart::findOrFail($request->id);
        $part->pn = $request->pn;
        $part->description = $request->description;
        $part->ded_price = $request->ded_price;
        $part->ger_price = $request->ger_price;
        $part->quick_reference = $request->quick_reference;
        $part->save();
        // $part->machine()->update([
        //         'sparepart_pn' => $request->pn
        //     ]);
        // $part->applicator()->update([
        //         'sparepart_pn' => $request->pn
        //     ]);
        $part->machines()
          ->newPivotStatement()
          ->update([
                'sparepart_pn' => $request->pn
            ]);
          $part->applicators()
          ->newPivotStatement()
          ->update([
                'sparepart_pn' => $request->pn
            ]);
          // $part->productionlines()
          // ->newPivotStatement()
          // ->update([
          //       'sparepart_pn' => $request->pn
          //   ]);


        return response()->json(['message' => 'Part Edited']);
    }

    public function editchild(Request $request)
    {
        $part = SparePart::findOrFail($request->parent_id);

        $part->children()
          ->newPivotStatement()
          ->where([
                ['parent_id', '=', $request->parent_id],
                ['child_id', '=', $request->child_id]])
          ->update([
                'quantity' => $request->quantity 
            ]);

        return response()->json(['message' => 'Child Edited']);
    }

    public function delete($id)
    {
        $part = SparePart::findOrFail($id);
        // $part->machines()->detach();
        // $part->machine()->delete();
        // $part->applicator()->delete();
        $part->deleted = '1';
        $part->save();
        return response()->json(['message' => 'Part Deleted']);
    }

    public function deletechild($parent,$child)
    {
        $part = SparePart::findOrFail($parent)->children()
                ->wherePivot('child_id', $child)->detach();
        return response()->json(['message' => 'Child Detached']);
    }

    public function index()
	{
		$parts = SparePart::with('machines')->where("deleted",False)->get();
	 	return response()->json($parts);
	}

    public function children($id)
    {
     $parent = SparePart::findOrFail($id);
      return $parent->children()->get(); 
      // return response()->json($children);
    }

    public function addchildren(Request $request)
    {
     $part = SparePart::findOrFail($request->parent_id);
      $part->children()->attach($request->child_id , [
          'quantity' => $request->quantity
      ]);    
      return response()->json(['message' => 'Child Added']);
    }

    public function addparttomachine(Request $request)
    {
       $part = SparePart::findOrFail($request->id);
            $part->machines()->attach($request->machine_id , [
                'quantity' => $request->quantity ,
                'sparepart_pn' => $request->pn]
            );
       

       // if(intval($request->parent_id) != 0){
       //     $parentpart = SparePart::findOrFail(intval($request->parent_id));
       //     $part->parent()->associate($parentpart);
       //     $part->save();
       // }


        return response()->json(['message' => 'Part Added']);
    }

    public function addparttoapplicator(Request $request,$len)
    {
      $part = SparePart::findOrFail($request->id);
      $part->applicators()->attach($request->applicator_id , [
          'quantity' => $request->quantity,
          'sparepart_pn' => $request->pn
      ]);
    return response()->json(['message' => 'Part Added']);
    }

    public function addparttoline(Request $request,$len)
    {
        // return response()->json(request(1));
       $part = SparePart::findOrFail(request(0)['id']);
       for ($i = 0; $i < $len ; $i++) {
            $part->productionlines()->attach(request($i)['productionline_id'] , [
                'S_N' => request($i)['S_N']
            ]);
        } 
        return response()->json(['message' => 'Part Added']);
    }

    // public function addparttoline(Request $request, $id)
    // {
    //   $part = SparePart::findOrFail($id);
    //   $part->productionlines()->attach(intval($request->productionline_id));
    //   $part->save();
    //   return response()->json(['message' => 'Part Added']);
    // }

    public function search($word){
        // return response()->json($request);

      $Parts = SparePart::search($word)->get();
      return response()->json($Parts);
    }

}
