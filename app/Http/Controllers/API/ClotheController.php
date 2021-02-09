<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Clothe;
use Illuminate\Http\Request;

class ClotheController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd(Clothe::active());
        return  Clothe::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Clothe $clothe)
    {
//        dd($request->all());

        $this->validate($request,[
            'title' => 'required|string|max:191',
        ]);


        $name = time().'.' . explode('/', explode(':',
                substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
        \Image::make($request->photo)->save(public_path('img/clothes_pics/').$name);
        $request->merge(['photo' => $name]);

        $clothe->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $clothe  =  Clothe::findOrfail($id);

 foreach ($clothe->commands as $command){
    $command->clothe()->dissociate();
    $command->clothe_id =  null;
    $command->save();
 }

       $clothe->delete();
    }
}
