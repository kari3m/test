<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
// use App\Plant;
// use App\Contact;

class CompanyController extends Controller
{
    public function index()
    {
      $companies = Company::All();
      return response()->json($companies);
    }

    public function show($id)
    {
        $company = Company::where("id",$id)->first();
        return response()->json($company);
    }


    public function store(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30'
        ]);
        Company::create([
            'name' => request ('name'),
            'address' => request ('address'),
            'contact_phone' => request ('contact_phone'),
            'contact_email' => request ('contact_email')
        ]);
        return response()->json(['message' => 'Company Added']);
    }

    public function edit(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|max:30'
        ]);
        $company = Company::findOrFail($request->id);
        $company->name = $request->name;
        $company->address = $request->address;
        $company->contact_email = $request->contact_email;
        $company->contact_phone = $request->contact_phone;


        $company->save();

        return response()->json(['message' => 'Company Edited', 'company' => Company::find($request->id)]);
    }

    public function delete($id)
    {
        // $id = $request::input('id');

        // DB::table('companies')
        //     ->where('id', $id)
        //     ->delete();
        // $this->deleteCompanyRef($id);


        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(['message' => 'Company Deleted']);
    }

    public function getPlants($id)
    {
        $company = Company::findOrFail($id);
        return $company->plants;
    }

    public function getContacts($id)
   {
       $company = Company::findOrFail($id);
       return $company->contacts;
   }

    public function search($word){
        // return response()->json($request);

      $companies = Company::search($word)->get();
      return response()->json($companies);
    }
}
