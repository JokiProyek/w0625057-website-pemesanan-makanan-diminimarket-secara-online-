<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sales_price')->where('sales_price', '<>', '')->inRandomOrder()->get()->take(8);
        $rproducts = Product::whereNotNull('regular_price')->where('regular_price', '<>', '')->inRandomOrder()->get()->take(2);
        $fproducts = Product::whereNotNull('featured')->where('featured', '<>', 'true')->inRandomOrder()->get()->take(8);
        return view('layouts.index', compact('categories', 'sproducts', 'rproducts', 'fproducts'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contact_store(Request $requuest)
    {
        $requuest->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required',
            'comment' => 'required|max:100',
        ]);

        $contact = new Contact();
        $contact->name = $requuest->name;
        $contact->email = $requuest->email;
        $contact->phone = $requuest->phone;
        $contact->comment = $requuest->comment;
        $contact->save();

        return redirect()->back()->with('success', 'Contact has been sent!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%$query%")
            ->take(8)
            ->get();

        return response()->json($results);
    }


}
