<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookOrder;
use App\Models\Order;
use Ramsey\Uuid\Uuid;
use Yajra\Datatables\Datatables;
use DB;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }
    public function datatables()
    {
        $orders = DB::table('orders')
            ->select('orders.id as order_id', 'orders.customer_name', 'orders.created_at as order_date', 'orders.invoice_number', 'orders.total_price', 'orders.status')
            ->orderBy('orders.created_at', 'desc')
            ->get();
        return Datatables::of($orders)
            ->addIndexColumn()
            ->addColumn('order_date', function ($item) {
                $date = date('d-m-Y H:i:s', strtotime($item->order_date));
                return "$date";
            })
            ->addColumn('total_price', function ($item) {
                return 'Rp. ' . number_format($item->total_price, 0, ',', '.');
            })
            ->addColumn('status', function ($item) {
                switch ($item->status) {
                    case 'SUBMIT':
                        return '<span class="badge bg-warning text-dark">' . $item->status . '</span>';
                        break;
                    case 'PROCESS':
                        return '<span class="badge bg-info text-light">' . $item->status . '</span>';
                        break;
                    case 'FINISH':
                        return '<span class="badge bg-success text-light">' . $item->status . '</span>';
                        break;
                    case 'CANCEL':
                        return '<span class="badge bg-danger text-light">' . $item->status . '</span>';
                        break;
                    default:
                    case 'SUBMIT':
                        return '<span class="badge bg-warning text-dark">' . $item->status . '</span>';
                        break;
                }
            })
            ->addColumn('action', function ($item) {
                if ($item->status != 'FINISH' && $item->status != 'CANCEL') {
                    if ($item->status == 'SUBMIT') {
                        return '
                        <a href="' . url('order/edit/' . $item->order_id) . '" class="btn btn-sm btn-warning">Edit</a>
                        <a href="' . url('order/detail/' . $item->order_id) . '" class="btn btn-info btn-sm"
                        >
                            Detail
                            </a>
                        <button type="button" id="btnDeleteOrder" delete_order_id="' . $item->order_id . '" invoice_number="' . $item->invoice_number . '" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteOrderModal">
                            Cancel
                            </button>
                        ';
                    }
                    return '
                        <a href="' . url('order/edit/' . $item->order_id) . '" class="btn btn-sm btn-warning">Edit</a>
                        <a href="' . url('order/detail/' . $item->order_id) . '" class="btn btn-info btn-sm"
                        >
                            Detail
                            </a>
                        ';
                }
                return '
                    <a href="' . url('order/detail/' . $item->order_id) . '" class="btn btn-info btn-sm"
                    >
                    Detail
                </a>
                    ';
            })
            ->rawColumns(['order_date', 'status', 'action'])
            ->make(true);
    }
    public function detail($id)
    {
        $order = DB::table('orders')
            ->join('book_order', 'book_order.order_id', '=', 'orders.id')
            ->join('books', 'book_order.book_id', '=', 'books.id')
            ->select('orders.id as order_id', 'orders.customer_name', 'orders.address', 'orders.created_at as order_date', 'orders.invoice_number', 'orders.total_price', 'orders.status', 'books.title', 'books.price', 'book_order.quantity')
            ->where('orders.id', '=', $id, 'and')
            ->orderBy('orders.created_at')
            ->get();
        $customer_name = $order[0]->customer_name;
        $address = $order[0]->address;
        $order_date = date('d-m-Y h:i:s', strtotime($order[0]->order_date));
        $invoice_number = $order[0]->invoice_number;
        $total_price = 'Rp. ' . number_format($order[0]->total_price, 0, ',', '.');
        $status = $order[0]->status;
        return view('orders.detail', compact('order', 'customer_name', 'address', 'order_date', 'invoice_number', 'total_price', 'status'));
    }
    public function create()
    {
        $books = Book::orderBy('created_at')->get();

        return view('orders.create', compact('books'));
    }
    public function store(Request $request)
    {
        $rules = [
            'buyer' => 'required|string',
            'address' => 'required|string',
            'book' => 'required|exists:books,id',
            'quantity' => 'required|numeric|min:0',
            '_nOrder' => 'required|numeric|min:1'
        ];
        $total = 0;
        if ($request->_nOrder > 1) {
            $order = new Order;
            $order->id = Uuid::uuid4()->getHex();
            $order->invoice_number = date('YmdHis');
            $order->status = 'SUBMIT';
            $order->customer_name = $request->buyer;
            $order->address = $request->address;
            $order->total_price = $total;
            $order->save();
            $flag_first_order = true;
            for ($i = 1; $i <= $request->_nOrder; $i++) {
                if ($flag_first_order) {
                    $this->validate($request, $rules);
                    $book = Book::find($request["book"]);
                    if ($book->stock >= (int)$request["quantity"]) {
                        $total += $book->price * (int)$request["quantity"];
                        $book_order = new BookOrder;
                        $book_order->book_id = $book->id;
                        $book_order->order_id = $order->id;
                        $book_order->quantity = (int)$request["quantity"];
                        if ($book_order->save()) {
                            $book->stock = $book->stock - (int)$request["quantity"];
                            $book->save();
                            $flag_first_order = false;
                        }
                    } else {
                        return redirect(url('order/create'))->with('failed', 'Book out of stock');
                    }
                }
                if (isset($request["book$i"]) && isset($request["quantity$i"])) {
                    $rules["book$i"] = 'required|exists:books,id';
                    $rules["quantity$i"] = 'required|numeric|min:0';
                    $this->validate($request, $rules);
                    $book = Book::find($request["book$i"]);
                    if ($book->stock >= (int)$request["quantity$i"]) {
                        $total += $book->price * (int)$request["quantity$i"];
                        $book_order = new BookOrder;
                        $book_order->book_id = $book->id;
                        $book_order->order_id = $order->id;
                        $book_order->quantity = (int)$request["quantity$i"];
                        if ($book_order->save()) {
                            $book->stock = $book->stock - (int)$request["quantity$i"];
                            $book->save();
                        }
                    } else {
                        return redirect(url('order/create'))->with('failed', 'Book out of stock');
                    }
                }
            }
            $order->total_price = $total;
            $order->save();
        } else {
            $this->validate($request, $rules);
            $order = new Order;
            $order->id = Uuid::uuid4()->getHex();
            $order->customer_name = $request->buyer;
            $order->address = $request->address;
            $order->invoice_number = date('YmdHis');
            $order->status = 'SUBMIT';
            $order->total_price = $total;
            $order->save();
            $book = Book::find($request["book"]);
            if ($book->stock >= (int)$request["quantity"]) {
                $total += $book->price * (int)$request["quantity"];
                $book_order = new BookOrder;
                $book_order->book_id = $book->id;
                $book_order->order_id = $order->id;
                $book_order->quantity = (int)$request["quantity"];
                if ($book_order->save()) {
                    $book->stock = $book->stock - (int)$request["quantity"];
                    $book->save();
                }
            } else {
                return redirect(url('order/create'))->with('failed', 'Book out of stock');
            }
            $order->total_price = $total;
            $order->save();
        }
        return redirect(url('orders'))->with('message', 'Order Successfully created');
    }
    public function edit($id)
    {

        $order = DB::table('orders')
            ->join('book_order', 'book_order.order_id', '=', 'orders.id')
            ->join('books', 'book_order.book_id', '=', 'books.id')
            ->select('orders.id as order_id', 'orders.customer_name', 'orders.address', 'orders.created_at as order_date', 'orders.invoice_number', 'orders.total_price', 'orders.status', 'books.title', 'books.price', 'book_order.quantity')
            ->where('orders.id', '=', $id, 'and')
            ->where('orders.status', '!=', 'FINISH', 'and')
            ->where('orders.status', '!=', 'CANCEL')
            ->orderBy('orders.created_at')
            ->get();

        $books = Book::orderBy('created_at')->get();
        $order_id = $order[0]->order_id;
        $customer_name = $order[0]->customer_name;
        $address = $order[0]->address;
        $order_date = date('d-m-Y h:i:s', strtotime($order[0]->order_date));
        $invoice_number = $order[0]->invoice_number;
        $total_price = 'Rp. ' . number_format($order[0]->total_price, 0, ',', '.');
        $status = $order[0]->status;
        return view('orders.edit', compact('order', 'books', 'order_id', 'customer_name', 'address', 'order_date', 'invoice_number', 'total_price', 'status'));
    }
    public function update(Request $request)
    {
        $order = Order::where('id', '=', $request->order_id, 'and')->where('status', '!=', 'FINISH', 'and')->where('orders.status', '!=', 'CANCEL')->firstOrFail();
        if ($order->status != 'PROCESS') {
            $book_order = BookOrder::where('order_id', '=', $order->id)->get();
            $rules = [
                'buyer' => 'required|string',
                'address' => 'required|string',
                'book' => 'required|exists:books,id',
                'quantity' => 'required|numeric|min:0',
                'status' => 'required|in:SUBMIT,PROCESS,FINISH',
                '_nOrder' => 'required|numeric|min:1'
            ];
            $total = 0;
            if ($request->_nOrder > 1) {
                $flag_first_order = true;
                for ($i = 1; $i <= $request->_nOrder; $i++) {
                    if ($flag_first_order) {
                        $this->validate($request, $rules);
                        // Reset Book Stock
                        foreach ($book_order as $bo) {
                            $book = Book::find($bo->book_id);
                            $book->stock = $book->stock + (int) $bo->quantity;
                            $book->save();
                        }
                        // Reset Book Ordered
                        $book_order->each->delete();
                        $order->customer_name = $request->buyer;
                        $order->address = $request->address;
                        $order->status = $request->status;
                        $book = Book::find($request["book"]);
                        if ($book->stock >= (int)$request["quantity"]) {
                            $total += $book->price * (int)$request["quantity"];
                            $book_order = new BookOrder;
                            $book_order->book_id = $book->id;
                            $book_order->order_id = $order->id;
                            $book_order->quantity = (int)$request["quantity"];
                            if ($book_order->save()) {
                                $book->stock = $book->stock - (int)$request["quantity"];
                                $book->save();
                                $flag_first_order = false;
                            }
                        } else {
                            return redirect(url('order/edit/' . $request->order_id))->with('failed', 'Book out of stock');
                        }
                    }
                    if (isset($request["book$i"]) && isset($request["quantity$i"])) {
                        $rules["book$i"] = 'required|exists:books,id';
                        $rules["quantity$i"] = 'required|numeric|min:0';
                        $this->validate($request, $rules);
                        $book = Book::find($request["book$i"]);
                        if ($book->stock >= (int)$request["quantity$i"]) {
                            $total += $book->price * (int)$request["quantity$i"];
                            $book_order = new BookOrder;
                            $book_order->book_id = $book->id;
                            $book_order->order_id = $order->id;
                            $book_order->quantity = (int)$request["quantity$i"];
                            if ($book_order->save()) {
                                $book->stock = $book->stock - (int)$request["quantity$i"];
                                $book->save();
                            }
                        } else {
                            return redirect(url('order/edit/' . $request->order_id))->with('failed', 'Book out of stock');
                        }
                    }
                }
                $order->total_price = $total;
                $order->save();
            } else {
                $this->validate($request, $rules);
                // Reset Book Stock
                foreach ($book_order as $bo) {
                    $book = Book::find($bo->book_id);
                    $book->stock = $book->stock + (int) $bo->quantity;
                    $book->save();
                }
                // Reset Book Ordered
                $book_order->each->delete();
                $order->customer_name = $request->buyer;
                $order->address = $request->address;
                $order->status = $request->status;
                $book = Book::find($request["book"]);
                if ($book->stock >= (int)$request["quantity"]) {
                    $total += $book->price * (int)$request["quantity"];
                    $book_order = new BookOrder;
                    $book_order->book_id = $book->id;
                    $book_order->order_id = $order->id;
                    $book_order->quantity = (int)$request["quantity"];
                    if ($book_order->save()) {
                        $book->stock = $book->stock - (int)$request["quantity"];
                        $book->save();
                    }
                } else {
                    return redirect(url('order/create'))->with('failed', 'Book out of stock');
                }
                $order->total_price = $total;
                $order->save();
            }
        } else {
            $this->validate($request, ['status' => 'required|in:PROCESS,FINISH']);
            if ($order->status == $request->status) {
                return redirect(url('orders'))->with('message', 'Order Successfully updated');
            }
            $order->status = $request->status;
            $order->update();
        }

        return redirect(url('orders'))->with('message', 'Order Successfully updated');
    }

    public function delete(Request $request)
    {
        $order = Order::where('id', '=', $request->delete_order_id, 'and')->where('status', '=', 'SUBMIT')->firstOrFail();
        $book_order = BookOrder::where('order_id', '=', $order->id)->get();
        // Reset Book Stock
        foreach ($book_order as $bo) {
            $book = Book::find($bo->book_id);
            $book->stock = $book->stock + (int) $bo->quantity;
            $book->save();
        }
        // Reset Book Ordered

        $order->status = 'CANCEL';
        $order->save();
        return redirect(url('orders'))->with('message', 'Order Successfully canceled');
    }
}
