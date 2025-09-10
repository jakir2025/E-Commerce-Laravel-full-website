<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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


    //courier

    public function courierEntry($order_id)
    {


      $order = Order::find($order_id);
     // dd($order);

      $apiEndpoint = "https://portal.packzy.com/api/v1/create_order";

      $header = [
        'Api-Key' => "eieihds2wtudp5ao3jbz4ptasni4ha54",
        'Secret-Key' => "7g7etlte9j5vymatazuq5tzl",
        'Content-Type' => "application/json"
      ];

      //body parameters--
      $invoiceNumber = $order->invoice_number;
      $customerName = $order->name;
      $customerPhone = $order->phone;
      $customerAddress = $order->address;
      $amount = $order->price;

      $payload = [
         'invoice' => $invoiceNumber,
         'recipient_name' => $customerName,
         'recipient_phone' => $customerPhone,
         'recipient_address' => $customerAddress,
         'cod_amount' => $amount,
      ];

      $response = Http::withHeaders($header)->post($apiEndpoint, $payload);
       $jsonData = $response -> json();
     // dd($jsonData);

     if(isset($jsonData['consignment'])){
      $order->tracking_code = $jsonData['consignment']['tracking_code'];
      $order->consignment_id = $jsonData['consignment']['consignment_id'];

      $order->save();
     }

     return redirect()->back();
    }
}
