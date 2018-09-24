<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Company;
use App\Plant;

class ContactController extends Controller
{
	public function index()
	{
		$contacts = Contact::with('plant','company')->get();
	 	return response()->json($contacts);
	}

    public function show($id)
    {
        $contact = Contact::where("id",$id)->first();
        return response()->json($contact);
    }


    public function store(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30'
        ]);
        Contact::create([
            'name' => request ('name'),
            'phone' => request ('phone'),
            'email' => request ('email'),
            'address' => request ('address'),
            'position' => request ('position'),
            'company_id' => request ('company_id'),
            'plant_id' => request ('plant_id')

        ]);
        return response()->json(['message' => 'Contact Added']);
    }

    public function edit(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30'
        ]);
        $contact = Contact::findOrFail($request->id);
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->address = $request->address;
      	$contact->position = $request->position;
      	$contact->company_id = $request->company_id;
      	$contact->plant_id = $request->plant_id;

        $contact->save();

        return response()->json(['message' => 'Contact Edited']);
    }

    public function delete($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return response()->json(['message' => 'Contact Deleted']);
    }

		public function search($word){
				// return response()->json($request);
//->with('plant','company')
			$contacts = Contact::search($word)->with('plant','company')->get();
			return response()->json($contacts);
		}
}
