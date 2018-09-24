<?php

use Illuminate\Http\Request;


Route::middleware('jwt.auth')->group(function () {


	Route::get('/user', function (Request $request) {return auth()->user(); });

	Route::get('/companies','CompanyController@index');
	Route::get('/companies/{id}','CompanyController@show');
	Route::get('/companies/plants/{id}','CompanyController@getPlants');
	Route::get('/companies/contacts/{id}','CompanyController@getContacts');
	Route::get('/companies/delete/{id}','CompanyController@delete');
	Route::post('/companies/add','CompanyController@store');
	Route::post('/companies/edit','CompanyController@edit');
	Route::get('/companies/search/{word}','CompanyController@search');


	Route::get('/plants','PlantController@index');
	Route::get('/plants/{id}','PlantController@show');
	Route::get('/plants/lines/{id}','PlantController@getLines');
	Route::get('/plants/contacts/{id}','PlantController@getContacts');
	Route::get('/plants/delete/{id}','PlantController@delete');
	Route::post('/plants/add','PlantController@store');
	Route::post('/plants/edit','PlantController@edit');
	Route::get('/plants/search/{word}','PlantController@search');


	Route::get('/contacts','ContactController@index');
	Route::get('/contacts/{id}','ContactController@show');
	Route::get('/contacts/delete/{id}','ContactController@delete');
	Route::post('/contacts/add','ContactController@store');
	Route::post('/contacts/edit','ContactController@edit');
	Route::get('/contacts/search/{word}','ContactController@search');


	Route::get('/productionlines','ProductionLineController@index');
	Route::get('/productionlines/delete/{id}','ProductionLineController@delete');
	Route::post('/productionlines/add','ProductionLineController@store');
	Route::post('/productionlines/edit','ProductionLineController@edit');

	Route::post('/productionlines/editproductionlineparts','ProductionLineController@editproductionlineparts');
	Route::post('/productionlines/editoneproductionlinepart/{oldsn}','ProductionLineController@editoneproductionlinepart');
	Route::get('/productionlines/detachparts/{part}/{line}','ProductionLineController@detachproductionlinepart');
	Route::get('/productionlines/detachonepart/{part}/{line}/{serial}','ProductionLineController@detachoneproductionlinepart');

	Route::post('/productionlines/editoneproductionlinemelter/{oldsn}','ProductionLineController@editoneproductionlinemelter');
	Route::get('/productionlines/detachmelters/{melter}/{line}','ProductionLineController@detachproductionlinemelter');
	Route::get('/productionlines/detachonemelter/{melter}/{line}/{serial}','ProductionLineController@detachoneproductionlinemelter');
	Route::post('/productionlines/editproductionlineapplicators','ProductionLineController@editproductionlineapplicators');
	Route::post('/productionlines/editoneproductionlineapplicator','ProductionLineController@editoneproductionlineapplicator');
	// Route::get('/productionlines/detachapplicators/{applicator}/{line}/{parent}','ProductionLineController@detachproductionlineapplicator');
	Route::get('/productionlines/detachoneapplicator/{applicator}/{line}','ProductionLineController@detachoneproductionlineapplicator');

	Route::get('/productionlines/search/{word}','ProductionLineController@search');
	Route::get('/productionlines/parts/{id}','ProductionLineController@productionlineparts');
	Route::get('/productionlines/melters/{id}','ProductionLineController@productionlinemelters');
	Route::get('/productionlines/applicators/{id}','ProductionLineController@productionlineapplicators');
	Route::get('/productionlines/allpartsserials/{line}','ProductionLineController@productionlineallpartsserials');
	Route::get('/productionlines/partserials/{part}/{line}','ProductionLineController@productionlinepartserials');
	// Route::get('/productionlines/applicatorserials/{applicator}/{line}/{parent}','ProductionLineController@productionlineapplicatorserials');
	Route::get('/productionlines/allmeltersserials/{line}','ProductionLineController@productionlineallmeltersserials');
	Route::get('/productionlines/melterserials/{melter}/{line}','ProductionLineController@productionlinemelterserials');
	Route::get('/productionlines/parentparts/{id}','ProductionLineController@productionlineparentparts');
	Route::get('/productionlines/parentapplicators/{id}','ProductionLineController@productionlineparentapplicators');


	Route::get('/machines','MachineController@index');
	Route::get('/machines/{id}','MachineController@show');
	Route::get('/machines/delete/{id}','MachineController@delete');
	Route::post('/machines/add','MachineController@store');
	Route::post('/machines/addmeltertoline/{len}','MachineController@addmeltertoline');
	Route::post('/machines/edit','MachineController@edit');
	// Route::post('/machines/editmachineparts/{oldparent}','MachineController@editmachineparts');
	Route::post('/machines/editonemachinepart','MachineController@editonemachinepart');
	// Route::post('/machines/editt','MachineController@editt');
	// Route::get('/machines/delette/{id}','MachineController@delette');
	// Route::get('/machines/detach/{part}/{machine}/{parent}','MachineController@detachmachinepart');
	Route::get('/machines/detachone/{part}/{machine}','MachineController@detachonemachinepart');
	Route::get('/machines/search/{name}','MachineController@search');
	Route::get('/machines/parts/{id}','MachineController@machineparts');
	// Route::get('/machines/partserials/{part}/{machine}/{parent}','MachineController@machinepartserials');
	// Route::get('/machines/parentparts/{id}','MachineController@machineparentparts');

	Route::get('/applicators','ApplicatorController@index');
	Route::get('/applicators/{id}','ApplicatorController@show');
	Route::get('/applicators/delete/{id}','ApplicatorController@delete');
	Route::post('/applicators/add','ApplicatorController@store');
	Route::post('/applicators/addapplicatortoline','ApplicatorController@addapplicatortoline');
	Route::post('/applicators/edit','ApplicatorController@edit');
	Route::post('/applicators/editapplicatorparts/{oldparent}','ApplicatorController@editapplicatorparts');
	Route::post('/applicators/editoneapplicatorpart/','ApplicatorController@editoneapplicatorpart');
	Route::post('/applicators/editt','ApplicatorController@editt');
	Route::get('/applicators/delette/{id}','ApplicatorController@delette');
	Route::get('/applicators/detach/{part}/{applicator}/{parent}','ApplicatorController@detachapplicatorpart');
	Route::get('/applicators/detachone/{part}/{applicator}','ApplicatorController@detachoneapplicatorpart');
	Route::get('/applicators/models/{name}','ApplicatorController@models');
	Route::get('/applicators/search/{name}','ApplicatorController@search');
	Route::get('/applicators/parts/{id}','ApplicatorController@applicatorparts');
	Route::get('/applicators/partserials/{part}/{applicator}/{parent}','ApplicatorController@applicatorpartserials');
	Route::get('/applicators/parentparts/{id}','ApplicatorController@applicatorparentparts');

	Route::get('/spareparts','SparePartController@index');
	Route::get('/spareparts/{id}','SparePartController@show');
	Route::get('/spareparts/delete/{id}','SparePartController@delete');
	Route::get('/spareparts/deletechild/{parent}/{child}','SparePartController@deletechild');
	Route::get('/spareparts/children/{id}','SparePartController@children');
	Route::get('/spareparts/search/{word}','SparePartController@search');
	Route::post('/spareparts/add','SparePartController@store');
	Route::post('/spareparts/addchildren','SparePartController@addchildren');
	Route::post('/spareparts/addmany/{len}','SparePartController@storemany');
	Route::post('/spareparts/edit','SparePartController@edit');
	Route::post('/spareparts/editchild','SparePartController@editchild');
	Route::post('/spareparts/addparttomachine','SparePartController@addparttomachine');
	Route::post('/spareparts/addparttoapplicator/{len}','SparePartController@addparttoapplicator');
	Route::post('/spareparts/addparttoline/{len}','SparePartController@addparttoline');
	Route::post('/spareparts/addparttoline','SparePartController@addparttoline');


});

//api/user/reg or login
Route::post('user/register', 'APIRegisterController@register');

Route::post('user/login', 'APILoginController@login');
