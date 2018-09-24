<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Machine;
use App\SparePart;


class MachineController extends Controller
{
    public function index()
    {
      $machines = Machine::with('mainPart')->get();
      return response()->json($machines);
    }

    public function machineparts($id)
    {
        // $parts = Machine::where("id",$id)->first()->spareParts()->with('machines')->get();
        $parts = DB::table('machine_sparepart')
                     ->select('sparepart_id as id','sparepart_pn','quantity')
                     ->where('machine_id', '=', $id)
                     ->groupBy('id','sparepart_pn','quantity')
                     ->get();
        return response()->json($parts);
    }

    
    
    public function show($id)
    {
        $machine = Machine::where("id",$id)->first()->mainPart()->get();
        return response()->json($machine);
    }


    public function store(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30',
            'sparepart_id' => 'required'
        ]);
        Machine::create([
            'name' => request ('name'),
            'sparepart_id' => request ('sparepart_id')
        ]);
        return response()->json(['message' => 'Machine Added']);
    }

    public function addmeltertoline(Request $request,$len)
    {
       $machine = Machine::findOrFail(request(0)['id']);
       for ($i = 0; $i < $len ; $i++) {
            $machine->productionLines()->attach(request($i)['productionline_id'] , [
                'S_N' => request($i)['S_N'],
                'melter_name' => request($i)['name']
            ]);
        } 
       

       // if(intval($request->parent_id) != 0){
       //     $parentpart = SparePart::findOrFail(intval($request->parent_id));
       //     $part->parent()->associate($parentpart);
       //     $part->save();
       // }


        return response()->json(['message' => 'Part Added']);
    }

    public function search($word){
      $machines = Machine::search($word)->get();
      return response()->json($machines);
    }


  //   public function assign(Request $request)
  //   {
  //       $this->validate(request(),[
  //           'machine_id' => 'required|max:30',
  //           'machine_serial' => 'required|max:30',
  //           'company_id' => 'required|max:30',
  //           'plant_id' => 'required|max:30',
  //           'productionline_id' => 'required|max:30'
  //       ]);
  //       DB::table('machine_productionline')->insert(
		//     [
  //           'machine_id' => request ('machine_id'),
  //           'machine_serial' => request ('machine_serial'),
  //           'company_id' => request ('company_id'),
  //           'plant_id' => request ('plant_id'),
  //           'productionline_id' => request ('productionline_id')
  //       	]
		// );
  //       return response()->json(['message' => 'Machine assigned to production line']);
  //   }

    public function edit(Request $request)
    {

        $this->validate(request(),[
            'name' => 'required|max:30'
        ]);
        $machine = Machine::findOrFail($request->id);
        $machine->name = $request->name;
        $machine->sparepart_id = $request->sparepart_id;
        $machine->save();

        return response()->json(['message' => 'Machine Edited']);
    }

    public function editonemachinepart(Request $request)
    {
        $machine = Machine::findOrFail($request->machine_id);
        
        $machine->spareParts()
        ->newPivotStatement()
        ->where([
              ['sparepart_id', '=', $request->id]])
        ->update([
              'quantity' => $request->quantity
          ]);
        

        return response()->json(['message' => 'Machine Edited']);
    }

    public function delete($id)
    {
        $machine = Machine::findOrFail($id);
        $machine->spareParts()->detach();
        $machine->productionLines()->detach();
        $machine->delete();
        return response()->json(['message' => 'Machine Deleted']);
    }

  public function detachonemachinepart($part,$machine)
    {
      $parts = Machine::findOrFail($machine)->spareParts()
              ->wherePivot('sparepart_id', '=', $part)->detach();
      
        return response()->json("detached successfully");
    }

// public function editt(Request $request)
//   {
//       return response()->json($request);

//       $this->validate(request(),[
//           'name' => 'required|max:30'
//       ]);
//       $part = SparePart::findOrFail($request->id);
//       $part->pn = $request->pn;

//       $part->save();

//       return response()->json(['message' => 'Part Edited']);
//   }

//   public function delette($id)
//   {
//       $part = SparePart::findOrFail($id);
//       $part->machines()->detach();
//       $part->delete();
//       return response()->json(['message' => 'Part Deleted']);
//   }
}
