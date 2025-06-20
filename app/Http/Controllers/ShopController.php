<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size', 12);
        $order = $request->query('order', -1);
        $f_categories = $request->query('categories');
        $f_vendors = $request->query('vendors');
        $min_price = $request->query('min_price') ? $request->query('min_price') : 1;
        $max_price = $request->query('max_price') ? $request->query('max_price') : 10000000;
        switch ($order) {
            case 1:
                $o_column = "created_at";
                $o_order = "DESC";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "ASC";
                break;
            case 3:
                $o_column = "regular_price";
                $o_order = "ASC";
                break;
            case 4:
                $o_column = "regular_price";
                $o_order = "DESC";
                break;
            default:
                $o_column = "id";
                $o_order = "DESC";
        }

        $categories = Category::orderBy('name')->get();
        $vendors = Vendor::orderBy('name')->get();

        // $query = Product::query();

        // if (!empty($f_categories)) {
        //     $categoryIds = array_filter(explode(',', $f_categories));
        //     if (count($categoryIds) > 0) {
        //         $query->whereIn('category_id', $categoryIds);
        //     }
        // }

        // if (!empty($f_vendors)) {
        //     $vendorIds = array_filter(explode(',', $f_vendors));
        //     if (count($vendorIds) > 0) {
        //         $query->whereIn('vendor_id', $vendorIds);
        //     }
        // }

        // $query->orderBy($o_column, $o_order);
        // $products = $query->paginate($size);
        $products = Product::where(function ($query) use ($f_categories) {
            $query->whereIn('category_id', explode(',', $f_categories))
                ->orWhereRaw("'" . $f_categories . "' = ''");
        })
            ->where(function ($query) use ($f_vendors) {
                $query->whereIn('vendor_id', explode(',', $f_vendors))
                    ->orWhereRaw("'" . $f_vendors . "' = ''");
            })
            ->where(function ($query) use ($min_price, $max_price) {
                $query->whereBetween('regular_price', [$min_price, $max_price]);
                    // ->orWhereBetween('sale_price', [$min_price, $max_price]);
            })
            ->orderBy($o_column, $o_order)
            ->paginate($size);
        return view('shop', compact(
            'products',
            'size',
            'order',
            'categories',
            'f_categories',
            'vendors',
            'f_vendors',
            'min_price',
            'max_price'
        ));
    }


    public function product_details($product_slug)
    {
        // ("Product Slug: " . $product_slug); // Cek slug yang diterima
        $product = Product::where('slug', $product_slug)->first();
        $categories = Category::all();
        // ($product); // Cek apakah $product berisi objek atau null
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view('details', compact('product', 'rproducts', 'categories'));
    }
}
