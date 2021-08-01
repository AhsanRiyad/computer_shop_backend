<?php

namespace App\Http\Controllers\Microcredit\TranscationMicrocredit;

use Illuminate\Http\Request;
use App\Http\Others\SampleEmpty;
use App\Models\Microcredit\Dps\Dps;
use App\Http\Controllers\Controller;
use App\Models\Microcredit\Loans\Loan;
use App\Models\Microcredit\FixedDeposit\FixedDeposit;
use App\Http\Resources\Microcredit\Transaction\Transaction;
use App\Models\Microcredit\TransactionMicrocredit\TransactionMicrocredit as T;

class TransactionMicrocredit extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transaction = T::all();
        return $transaction;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        //
        $data = $request->all();
        if($type == 'dps'){
            $Dps =  Dps::find($data['dpsOrLoan_id']);
            unset($data['dps_id']);
            $Dps->transactionMicrocredit()->create($data);
            return $Dps->with(['transactionMicrocredit'])->get();
        }else if($type == 'fixedDeposit'){
            $FixedDeposit =  FixedDeposit::find($data['fdr_id']);
            unset($data['fdr_id']);
            return $FixedDeposit;
        }else if($type == 'loan'){
            $Loan =  Loan::find($data['dpsOrLoan_id']);
            unset($data['loan_id']);
            $Loan->transactionMicrocredit()->create($data);
            return $Loan;
        }
        // return $dps->transactionMicrocredit;
        // return $dps->transactionMicrocredit()->create(['amount' => 100]);

    }

    public function search(Request $req)
    {
        // return $req->search;

        if (T::where('id', 'like', '%' . $req->q . '%')->orWhere('amount', 'like', '%' . $req->q . '%')->count() > 0) {
            return Transaction::collection(T::with(['created_by'])->where('id', 'like', '%' . $req->q . '%')->orWhere('amount', 'like', '%' . $req->q . '%')->paginate(10));
        } else {
            return  json_encode(new SampleEmpty([]));
        };

        // return $req->q;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    
    public function getInstalment(Request $req)
    {
        //
        if ($req->q == ''
        ) {
            // return T::with(['created_by'])->where('transactionable_type' , 'App\Models\Microcredit\Dps\Dps')
            //     ->orWhere('transactionable_type', 'App\Models\Microcredit\Loans\Loan')
            // ->paginate(10);

            return Transaction::collection(T::with(['created_by'])->paginate(10));
        } else {
            return $this->search($req);
        }
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
        //
    }
}
