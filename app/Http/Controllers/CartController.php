<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }
    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('checkout');
    }
    public function place_an_order(Request $request)
    {
        $request->validate([
            'table_number' => 'required|unique:tables,table_number|max:20',
            'type' => 'required|in:dine-in,takeaway',
            'capacity' => 'required|integer|min:1',
            'mode' => 'required|in:cash,qris',
            'description' => 'nullable|string|max:255',
        ]);

        $table = new Table();
        $table->table_number = $request->table_number;
        $table->capacity = $request->capacity;
        $table->description = $request->description;
        $table->save();


        $this->setAmountForCheckout();
        $subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
        $total = floatval(str_replace(',', '', Cart::instance('cart')->total()));
        $user = Auth::user();
        $order = new Order();
        $order->user_id = $user->id;
        $order->subtotal = $subtotal;
        $order->total = $total;
        $order->type = $request->type;
        $order->name = $user->name;
        $order->table_id = $table->id;
        $order->save();

        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->name = $item->name;
            $orderItem->rstatus = false;
            $orderItem->save();
        }

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->order_id = $order->id;
        $transaction->mode = $request->mode;
        $transaction->status = 'pending';
        $transaction->save();
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('discounts');
        Session::put('order_id', $order->id);
        return redirect()->route('cart.order.confirmation');
    }

    public function setAmountForCheckout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }
        Session::put('checkout', [
            'discount' => 0,
            'subtotal' => Cart::instance('cart')->subtotal(),
            'tax' => Cart::instance('cart')->tax(),
            'total' => Cart::instance('cart')->total(),
        ]);
    }

    public function order_confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact("order"));
        }
        return redirect()->route('cart.index');
    }
}
