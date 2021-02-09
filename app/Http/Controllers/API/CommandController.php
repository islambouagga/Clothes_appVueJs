<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Clothe;
use App\Models\Command;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandController extends Controller
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
        return  Command::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Command $command)
    {
//        $this->validate($request,[
//            'client_name' => 'required|string|max:191',
//            'price' => 'required',
//        ]);

        $user =  User::findOrfail(Auth::id());
        $clothe  =  Clothe::findOrfail($request->clothe_id);


       $command->create(
           $request->all()
           +
           [
               'user_id' => Auth::id(),
               'clothe_title' => $clothe->title
           ]
       );
        $command->user()->associate($user);
        $command->clothe()->associate($clothe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function show(Command $command)
    {
        return $command->clothe->title;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Command $command)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Http\Response
     */
    public function destroy(Command $command)
    {
        //
    }
}
