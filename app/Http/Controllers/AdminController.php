<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Vendor;
use Carbon\Carbon;
use DB;
use Intervention\Image\Laravel\Facades\Image;
use File;
use Illuminate\Http\Request;
use Str;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get()->take(10);

        $dashboardDatas = DB::select("
            SELECT 
                sum(total) AS TotalAmount,
                sum(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
                sum(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
                sum(IF(status='canceled', total, 0)) AS TotalCanceledAmount,
                count(*) AS Total,
                sum(IF(status='ordered', 1, 0)) AS TotalOrdered,
                sum(IF(status='delivered', 1, 0)) AS TotalDelivered,
                sum(IF(status='canceled', 1, 0)) AS TotalCanceled
            FROM orders
        ");
        $monthlyDatas = DB::select("
                SELECT 
                    months.MonthNo,
                    months.MonthName,
                    IFNULL(SUM(D.total), 0) AS TotalAmount,
                    IFNULL(SUM(IF(D.status = 'ordered', D.total, 0)), 0) AS TotalOrderedAmount,
                    IFNULL(SUM(IF(D.status = 'delivered', D.total, 0)), 0) AS TotalDeliveredAmount,
                    IFNULL(SUM(IF(D.status = 'canceled', D.total, 0)), 0) AS TotalCanceledAmount
                FROM (
                    SELECT 1 AS MonthNo, 'Jan' AS MonthName UNION
                    SELECT 2, 'Feb' UNION
                    SELECT 3, 'Mar' UNION
                    SELECT 4, 'Apr' UNION
                    SELECT 5, 'May' UNION
                    SELECT 6, 'Jun' UNION
                    SELECT 7, 'Jul' UNION
                    SELECT 8, 'Aug' UNION
                    SELECT 9, 'Sep' UNION
                    SELECT 10, 'Oct' UNION
                    SELECT 11, 'Nov' UNION
                    SELECT 12, 'Dec'
                ) months
                LEFT JOIN orders D 
                    ON MONTH(D.created_at) = months.MonthNo 
                    AND YEAR(D.created_at) = YEAR(NOW())
                GROUP BY months.MonthNo, months.MonthName
                ORDER BY months.MonthNo
            ");


        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $orderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $deliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $canceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());
        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

        return view('admin.index', compact(
            'orders',
            'dashboardDatas',
            'monthlyDatas',
            'AmountM',
            'orderedAmountM',
            'deliveredAmountM',
            'canceledAmountM',
            'TotalAmount',
            'TotalOrderedAmount',
            'TotalDeliveredAmount',
            'TotalCanceledAmount'
        ));
    }

    public function products()
    {
        $products = Product::orderBy('id', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }
    public function vendors()
    {
        $vendors = Vendor::orderBy('id', 'DESC')->paginate();
        return view('admin.vendors', compact('vendors'));
    }

    public function add_vendor()
    {
        return view('admin.vendor-add');
    }

    public function vendor_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:vendors,slug',
            'mobile' => ['required', 'digits_between:10,14', 'regex:/^08[0-9]+$/', 'unique:vendors'],
        ]);

        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->slug = str::slug($request->name);
        $vendor->mobile = $request->mobile;
        $vendor->save();
        return redirect()->route('admin.vendors')->with('status', 'Vendor has been added successfully');
    }

    public function vendor_edit($id)
    {
        $vendor = Vendor::find($id);
        return view('admin.vendor-edit', compact('vendor'));
    }

    public function vendor_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:vendors,slug',
            'mobile' => ['required', 'digits_between:10,14', 'regex:/^08[0-9]+$/', 'unique:vendors'],
        ]);

        $vendor = Vendor::find($request->id);
        $vendor->name = $request->name;
        $vendor->slug = str::slug($request->name);
        $vendor->mobile = $request->mobile;
       
        $vendor->save();
        return redirect()->route('admin.vendors')->with('status', 'Vendor has been updated successfully');
    }


    public function GenerateVendorThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/vendors');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124);
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function vendor_delete($id)
    {
        $vendor = Vendor::find($id);
        if (File::exists(public_path('uploads/vendors') . '/' . $vendor->image)) {
            File::delete(public_path('uploads/vendors') . '/' . $vendor->image);
        }
        $vendor->delete();
        return redirect()->route('admin.vendors')->with('status', 'Vendor has been deleted successfully');
    }


    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function category_add()
    {
        return view('admin.category-add');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'mobile' => ['digits_between:10,14', 'regex:/^08[0-9]+$/', 'unique:vendors'],
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = str::slug($request->name);
        $category->mobile = $request->mobile;

        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been added successfully');
    }
    public function GenerateCategoryThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124);
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'mobile' => ['digits_between:10,14', 'regex:/^08[0-9]+$/', 'unique:vendors'],
        ]);
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = str::slug($request->name);
        $category->mobile = $request->mobile;

        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been updated successfully');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
            File::delete(public_path('uploads/categories') . '/' . $category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category has been deleted successfully');
    }

    public function product_add()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $vendors = Vendor::select('id', 'name')->orderBy('name')->get();
        return view('admin.products-add', compact('categories', 'vendors'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'regular_price' => 'required',
            'sales_price' => 'nullable',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:3000',
            'category_id' => 'required',
            'vendor_id' => 'required'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->regular_price = $request->regular_price;
        $product->sales_price = $request->sales_price;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->vendor_id = $request->vendor_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {
            $allowedfileExtion = ['png', 'jpg', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtion);
                if ($gcheck) {
                    $gfileName = $current_timestamp . '-' . $counter . '.' . $gextension;
                    $this->GenerateProductThumbnailImage($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }
        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('admin.products')->with('status', 'Product has been update successfully');
    }


    public function GenerateProductThumbnailImage($image, $imageName)
    {
        $destinationPathThumbnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $img = Image::read($image->path());

        $img->cover(540, 689, "top");
        $img->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);

        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail . '/' . $imageName);
    }


    // Ini yang ngisi admin show order Amel sampai:
    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.orders', compact('orders'));
    }
    // sampai sini


    // ini bagian Admin Show Order Details
    public function order_details($order_id)
    {
        $order = Order::find($order_id);
        $order_items = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('admin.order-details', compact('order', 'order_items', 'transaction'));
    }


    // ini bagian  Admin Update Order Status
    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } else if ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        $order->save();

        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }
        return back()->with('status', 'Status changed successfully!');
    }
    public function product_edit($id)
    {
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $vendors = Vendor::select('id', 'name')->orderBy('name')->get();
        return view('admin.products-edit', compact('product', 'categories', 'vendors'));
    }

    public function product_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'regular_price' => 'required',
            'sales_price' => 'nullable',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'category_id' => 'required',
            'vendor_id' => 'required'
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->regular_price = $request->regular_price;
        $product->sales_price = $request->sales_price;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->vendor_id = $request->vendor_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {
            foreach (explode(',', $product->images) as $ofile) {
                if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
                    File::delete(public_path('uploads/products') . '/' . $product->image);
                }
                if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
                    File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
                }
            }
            $allowedfileExtion = ['png', 'jpg', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtion);
                if ($gcheck) {
                    $gfileName = $current_timestamp . '-' . $counter . '.' . $gextension;
                    $this->GenerateProductThumbnailImage($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }
        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('admin.products')->with('status', 'Product has been update successfully');
    }

    public function product_delete($id)
    {
        $product = Product::find($id);
        if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
            File::delete(public_path('uploads/products') . '/' . $product->image);
        }
        if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
            File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
        }
        foreach (explode(',', $product->images) as $ofile) {
            if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
                File::delete(public_path('uploads/products') . '/' . $product->image);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
            }
        }
        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully');
    }
    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }

    public function contact_delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('admin.contacts')->with('status', 'Message delete successfully');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%$query%")
            ->orWhere('slug', 'LIKE', "%$query%")
            ->take(8)
            ->get();

        return response()->json($results);
    }
}
