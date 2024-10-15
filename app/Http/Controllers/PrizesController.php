<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prize;
use App\Http\Requests\PrizeRequest;
use Illuminate\Http\Request;
use DB;
use Session;

class PrizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $prizes = Prize::all();         
        $prizes2=$prizes;
        //$data=$prizes2->toArray();   
        return view('prizes.index', compact('prizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(){
        
        return view('prizes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PrizeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PrizeRequest $request){
        $sum_of_probability = floatval(Prize::sum('probability'));

        $rules = [            
            'title' => 'required', 
            'probability' => 'required',
        ];

        $this->validate($request, $rules);

        $total_count=$sum_of_probability+ floatval($request->input('probability'));

        if($total_count > 100){
            return redirect()->back()->with('error','The probability field must not be greater than '.(100-$sum_of_probability));
        }

        $prize = new Prize;
        $prize->title = strip_tags($request->input('title'));
        $prize->probability = floatval($request->input('probability'));
        $prize->save();

        return to_route('prizes.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $prize = Prize::findOrFail($id);
        return view('prizes.edit', ['prize' => $prize]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PrizeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PrizeRequest $request, $id)
    {

        $sum_of_probability = floatval(Prize::sum('probability'));

        $rules = [            
            'title' => 'required', 
            'probability' => 'required',
        ];

        $this->validate($request, $rules);

        $total_count=$sum_of_probability+ floatval($request->input('probability'));

        if($total_count > 100){
            return redirect()->back()->with('error','The probability field must not be greater than '.(100-$sum_of_probability));
        }

        $prize = Prize::findOrFail($id);
        $prize->title = $request->input('title');
        $prize->probability = floatval($request->input('probability'));
        $prize->save();

        return to_route('prizes.index')->with('success','Sucessfully updated. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $prize = Prize::findOrFail($id);
        $prize->delete();

        return to_route('prizes.index')->with('success','Sucessfully Deleted. ');
    }


    public function simulate(Request $request) {

        //$prizes = Prize::with('simulate')->get();

        //echo "<pre>"; print_r($prizes); exit;
        $prizes = Prize::orderBy('probability','ASC')->get();
        Prize::where('id','!=','0')->update(['award'=>0]);

        foreach ($prizes as $key => $pl) {
            $res=$this->get_total_prize($request->number_of_prizes,$pl->probability);
            $prize = Prize::findOrFail($pl->id);            
            $prize->award = $res['award'];
            $prize->actual = $res['actual'];
            $prize->save();
        }

       /* for ($i = 0; $i < $request->number_of_prizes ?? 10; $i++) {
            Prize::nextPrize();
        } */

        return to_route('prizes.index');
    }

    public function get_total_prize($total, $probability){

        $award = Prize::sum('award');
        $res=array();
        $prc=round($total/100* round($probability,0,PHP_ROUND_HALF_DOWN));
        $res['award']=$prc;
        $prc=$prc*$probability;
        $res['actual']=sqrt($prc);

        return $res;

    }


    public function reset()
    {
        // TODO : Write logic here
        return to_route('prizes.index');
    }
}
