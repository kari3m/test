<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plant;
use App\Company;

class PlantController extends Controller
{
    // public function index()
    // {
    //   $plants = Plant::All();
    //   return response()->json($plants);
    // }

    public function show($id)
    {
        $plant = Plant::where("id",$id)->first();
        return response()->json($plant);
    }


    public function store(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30',
            'company_id' => 'required'
        ]);
        Plant::create([
            'name' => request ('name'),
            'location' => request ('location'),
            'company_id' => request ('company_id')
        ]);
        return response()->json(['message' => 'Plant Added']);
    }

    public function edit(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30',
            'company_id' => 'required'
        ]);
        $plant = Plant::findOrFail($request->id);
        $plant->name = $request->name;
        $plant->location = $request->location;
        $plant->company_id = $request->company_id;

        $plant->save();

        return response()->json(['message' => 'Plant Edited']);
    }

    public function delete($id)
    {
        $plant = Plant::findOrFail($id);
        $plant->delete();
        return response()->json(['message' => 'Plant Deleted']);
    }

    public function index()
	{
		$plants = Plant::with('company')->get();
	 	return response()->json($plants);
	}

    public function getLines($id)
    {
        $plant = Plant::findOrFail($id);
        return $plant->productionLines;
    }
    public function getContacts($id)
    {
        $plant = Plant::findOrFail($id);
        return $plant->contacts;
    }
    public function search($word){
        // return response()->json($request);

      $plants = Plant::search($word)->with('company')->get();
      return response()->json($plants);
    }
}
