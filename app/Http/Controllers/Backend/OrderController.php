<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showOrders(Request $request, $status)
    {
         if(isset($request->search) && $status == 'all'){
           $orders = Order::with('orderDetails')
           ->where('phone', 'LIKE', '%'.$request->search.'%')
           ->orWhere('invoice_number', 'LIKE', '%'.$request->search.'%')
           ->orWhere('name', 'LIKE', '%'.$request->search.'%')
           ->paginate(50);
         }

       else if(isset($request->search)  && $status != 'all'){
           $orders = Order::with('orderDetails')
           ->where('status', $status)
           ->where('phone', 'LIKE', '%'.$request->search.'%')
           ->orWhere('invoice_number', 'LIKE', '%'.$request->search.'%')
           ->orWhere('name', 'LIKE', '%'.$request->search.'%')
           ->paginate(50);
         }
        else{
           if($status == 'all'){
             $orders = Order::with('orderDetails')->paginate(50);
           }
           else{
             $orders = Order::with('orderDetails')->where('status', $status)->paginate(50);
           }
        }
         // $orders = Order::with('orderDetails')->paginate(50);
        return view('backend.order.show-orders', compact('orders', 'status'));
    }

    // public function pendingOrders()
    // {
    //      if(isset($request->search)){
    //        $orders = Order::with('orderDetails')
    //        ->where('status', 'pending')
    //        ->where('phone', 'LIKE', '%'.$request->search.'%')
    //        ->orWhere('invoice_number', 'LIKE', '%'.$request->search.'%')
    //        ->orWhere('name', 'LIKE', '%'.$request->search.'%')
    //        ->paginate(50);
    //      }
    //     else{
    //         $orders = Order::with('orderDetails')->where('status', 'pending')->paginate(50);
    //     }
    //      // $orders = Order::with('orderDetails')->paginate(50);
    //     return view('backend.order.show-orders', compact('orders'));

    // }

    public function updateOrderStatus(Request $request, $id)
    {

        $order = Order::find($id);
        $order->status = $request->status;

        $order->save();
        return redirect()->back();
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        $orderDetails = OrderDetails::where('order_id', $id)->get();
       
        foreach($orderDetails as $Details){
            $Details->delete();
        }

        $order->delete();
        toastr()->success('Order deleted successfully');
        Return redirect()->back();

    }

    public function editOrder($id)
    {
        $order = Order::with('orderDetails')->where('id', $id)->first();
        return view('backend.order.edit-orders', compact('order'));
    }
}
