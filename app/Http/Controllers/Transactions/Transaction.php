<?php

namespace App\Http\Controllers\Transactions;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Clients\Client;
use App\Http\Others\SampleEmpty;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Transactions\Transaction as C;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Transactions\Transaction as CR;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $all =  parent::toArray($request);
        $all['debit'] = $this->debit();
        $all['credit'] = $this->credit();
        $all['needToPay'] =  round( $this->credit() - $this->debit() , 2 );
        return $all;
    }
}

class ClientResourceSeller extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $all =  parent::toArray($request);
        $all['debit'] = $this->debitSeller();
        $all['credit'] = $this->creditSeller();
        $all['needToPay'] =  round( $this->debitSeller() - $this->creditSeller() , 2) ;
        return $all;
    }
}

class ClientLedgerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $all =  parent::toArray($request);
        $all['total'] = $this->getTotal();
        return $all;
    }
}

class ClientResourceCustomer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $all =  parent::toArray($request);
        $all['debit'] = $this->debitCustomer();
        $all['credit'] = $this->creditCustomer();
        $all['needToPay'] = round( $this->debitCustomer() - $this->creditCustomer()  );
        return $all;
    }
}

class TransactionLedgerTranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $all =  parent::toArray($request);
        $all['date'] = $this->date;
        $all['amount'] = $this->amount;
        $all['is_debit'] = $this->is_debit;
        $all['name'] = $this->client->name;
        $all['order_id'] = $this->order_id == null ? 0 :
        $this->order_id;
        
        return $all;
    }
}

class TransactionLedgerOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $all =  parent::toArray($request);
        $all['date'] = $this->date;
        $all['amount'] = $this->total;
        $all['is_debit'] = $this->client->type == 0 ? true : false;
        $all['name'] = $this->client->name;
        $all['order_id'] = $this->id;

        return $all;
    }
}

class Transaction extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        //
        // return $req->q;
        if ($req->q == '') {
            return CR::collection(C::with(['client'])->orderBy('id', 'desc')->paginate(10));
        } else {
            return $this->search($req);
        }
    }

    public function search(Request $req)
    {
        // return $req->search;

        if (C::where('id', 'like', '%' . $req->q . '%')->orWhere('order_id', 'like', '%' . $req->q . '%')->count() > 0) {
            return CR::collection(C::with(['client'])->where('id', 'like', '%' . $req->q . '%')->orWhere('order_id', 'like', '%' . $req->q . '%')->paginate(10));
        } else {
            return  json_encode(new SampleEmpty([]));
        };

        // return $req->q;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        foreach ($request->all() as $value) {
            C::Create($value);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        C::create($request->all());
        return new CR($request->all());

        // $product->save($parameters);

        // return $request;
        // $a = new P;
        // $a->name = $request->name;
        // return $a->save();
        // return $user;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_by_order(Request $request, $order_id)
    {
        //
        $order = Order::find($order_id);
        $info = $request->all();
        $info['client_id'] = $order->client_id;
        if ($order->type == 0) {
            $info['is_debit'] = true;
        } else {
            $info['is_debit'] = false;
        }
        $order->transactions()->create($info);
        return new CR($info);

        // $product->save($parameters);

        // return $request;
        // $a = new P;
        // $a->name = $request->name;
        // return $a->save();
        // return $user;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_by_client(Request $request, $client_id)
    {
        //
        $client = Client::find($client_id);
        $client->transactions()->create($request->all());
        return new CR($request->all());

        // $product->save($parameters);

        // return $request;
        // $a = new P;
        // $a->name = $request->name;
        // return $a->save();
        // return $user;
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
        // return 'value';
        return new CR(C::with(['client'])->find($id));
    }

    public function transactionByClient()
    {
        //
        // return DB::table('transactions')
        //     ->select(DB::raw('sum(amount) as amount'))
        //     ->where('is_debit',  true)
        //     ->groupBy('client_id')
        //     ->get();
        return ClientResource::collection( Client::paginate(10) );
    }

    public function transactionBySeller()
    {
        //
        // return DB::table('transactions')
        //     ->select(DB::raw('sum(amount) as amount'))
        //     ->where('is_debit',  true)
        //     ->groupBy('client_id')
        //     ->get();
        return ClientResourceSeller::collection( Client::where('type' , 'seller')->paginate(10) );
    }

    public function transactionByCustomer()
    {
        //
        // return DB::table('transactions')
        //     ->select(DB::raw('sum(amount) as amount'))
        //     ->where('is_debit',  true)
        //     ->groupBy('client_id')
        //     ->get();
        // return Client::where('type', 'customer')->paginate(10);
        return ClientResourceCustomer::collection( Client::where('type' , 'customer')->paginate(10) );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_by_order($order_id)
    {
        //
        // return new CR(Order::find($order_id)->Transactions()->paginate(10));
        return new CR(Order::find($order_id)->Transactions()->paginate(10));
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_by_client($client_id)
    {
        //
        return new CR(Client::find($client_id)->Transactions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transactionLedger($period , $client_id)
    {
        //
        // $time = strtotime($period);
        // $month = date("m", $time);
        // $year = date("Y", $time);

        $month =  explode('-' , $period)[1];
        $year =  explode('-' , $period)[0];
        // return $month;
        // return $month;

        // return CR::collection(Client::find($client_id)->Transactions->where('is_debit' , false));
        // $transactions = Client::find($client_id)->Transactions->take(10);
        // $transactions = Client::find($client_id)->Transactions->where('date', 'regexp' ,  '(2021-08-12)')->take(10);

        $transactions = TransactionLedgerTranResource::collection( C::where('client_id' , $client_id)->where('date' , 'like' , '%'. $year .'-'. $month.'%')->get());
        $orders = TransactionLedgerOrderResource::collection(  Order::where('client_id' , $client_id)->where('date', 'like', '%' . $year . '-' . $month . '%')->get() );

        // return $orders;

        $transactions1 = json_decode( json_encode( $transactions ) );
        $orders1 = json_decode( json_encode($orders ) );
        return array_merge($transactions1, $orders1);
        
        // return $transactions1;
        // return array_merge($transactions->data, $orders->toArray());
        // $a =  (object) $transactions;
        // $orders = ClientLedgerResource::collection(Client::find($client_id)->Orders->take(10));
        // $orders = ClientLedgerResource::collection(Client::find($client_id)->Orders->where('date',  '2021-08-12')->take(10) );
        // return $transactions->merge($orders)->sortBy('date');

        // return collect(array_merge( $transactions->toArray(), $orders->toArray() ))->sortBy('date');

        // return compact('transactions', 'orders');
        // return $period;
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
        if (C::where('id', $id)->update($request->all())) {
            return new CR(C::find($id));
        };
        abort(403, 'Not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_by_order(Request $request, $order_id, $transaction_id)
    {
        //
        $transaction =  C::find($transaction_id);
        $transaction->update($request->all());
        return response($transaction->refresh(), 200);

        /*if ($product->save($request->all())) {
            return new CR($request->all());
        };
        abort(403, 'Not found');*/
    }

    public function incomeStatement($period)
    {
        //
        $month =  explode('-', $period)[1];
        $year =  explode('-', $period)[0];
        // C::groupBy('transactionable_id')->where('date', 'like', '%' . $year . '-' . $month . '%')->select('browser', DB::raw("sum('amount')"))->get();
        $incomeList =
            // C::groupBy('transactionable_id')->where('date', 'like', '%' . $year . '-' . $month . '%')->select('transactionable_id', DB::raw("sum('amount')"))->with(['transactionable'])->get();

            DB::table('transactions')
            ->where('date', 'like', '%' . $year . '-' . $month . '%')
            ->where('transactionable_type', 'income')
            ->select('transactions.transactionable_id', 'incomes.name', DB::raw("sum(transactions.amount) as amount"))
            ->join('incomes', 'transactions.transactionable_id', '=', 'incomes.id')
            ->groupBy('transactions.transactionable_id')
            ->get();
        
        $expenseList =
        DB::table('transactions')
        ->where('date', 'like', '%' . $year . '-' . $month . '%')
        ->where('transactionable_type', 'expense')
        ->select('transactions.transactionable_id', 'expenses.name', DB::raw("sum(transactions.amount) as amount"))
        ->join('expenses', 'transactions.transactionable_id', '=', 'expenses.id')
        ->groupBy('transactions.transactionable_id')
        ->get();


        $incomeTotal = C::where('transactionable_type' , 'income')->where('date' , 'like' , '%'. $year .'-'. $month.'%')->sum('amount');
        $expenseTotal =  C::where('transactionable_type' , 'expense')->where('date' , 'like' , '%'. $year .'-'. $month.'%')->sum('amount');
        $purchaseTotal = Order::where('type', 0)->where('date' , 'like' , '%'. $year .'-'. $month.'%')->get()->sum('total');
        $sellTotal = Order::where('type', 1)->where('date' , 'like' , '%'. $year .'-'. $month.'%')->get()->sum('total');
        // $p =  $purchaseTotal->sum('total');

        return compact('incomeTotal', 'expenseTotal', 'purchaseTotal' , 'sellTotal' , 'incomeList' , 'expenseList');
        // return $period;
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
        $menu = C::find($id);
        if (C::destroy($id)) {
            return new CR($menu);
        }
        abort(403, 'Not found');
    }
}
