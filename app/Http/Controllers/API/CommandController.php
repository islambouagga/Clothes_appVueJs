<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Clothe;
use App\Models\Command;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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






    public function search(){
        $qq = \Request::get('q');
        $a = \Request::get('a');
        $b = \Request::get('b');
//        dd($q ,$a);
        $start_date = Carbon::parse($a)
            ->toDateTimeString();

        $end_date = Carbon::parse($b)
            ->toDateTimeString();

        $query = Command::query();
//        dd($query->get());
        $query->when( \Request::get('a') != null &&  \Request::get('b') != null , function ($q){
            $start_date = Carbon::parse( \Request::get('a'))
                ->toDateTimeString();

            $end_date = Carbon::parse( \Request::get('b'))
                ->toDateTimeString();
            return $q->whereBetween('dateToGive',[$start_date,$end_date]);
        });

        $query->when( \Request::get('c') != null &&  \Request::get('d') != null , function ($q){
            $start_date = Carbon::parse( \Request::get('c'))
                ->toDateTimeString();

            $end_date = Carbon::parse( \Request::get('d'))
                ->toDateTimeString();
            return $q->whereBetween('created_at',[$start_date,$end_date]);
        });
        $query->when(\Request::get('e') != null , function ($q){
            $e = \Request::get('e');

            return $q->where('isPaid',$e);
        });

        $query->when(\Request::get('q') != null , function ($q){
            $qq = \Request::get('q');
            return $q->where('client_name','LIKE',"%$qq%");
        });

        $users = $query->paginate(20);




//        if ($search = \Request::get('a') ) {
//            $start_date = Carbon::parse($a)
//                ->toDateTimeString();
//
//            $end_date = Carbon::parse($b)
//                ->toDateTimeString();
////            dd($start_date,$end_date);
//            $users  = Command::whereBetween('created_at',[$start_date,$end_date])->paginate(20);
//        }else{
//            $users = Command::latest()->paginate(5);
//        }



//
//        if ($search = \Request::get('q') ) {
////            dd($search);
//            $users = Command::where(function($query) use ($search){
//                $query->where('client_name','LIKE',"%$search%")
//                    ->orWhere('color','LIKE',"%$search%")
//                    ->orWhere('price','LIKE',"%$search%")
//                    ->orWhere('dateToGive','LIKE',"%$search%")
//                    ->orWhere('clothe_title','LIKE',"%$search%");
//
//            })->paginate(20);
//        }else{
//            $users = Command::latest()->paginate(5);
//        }

        return $users;

    }
}
