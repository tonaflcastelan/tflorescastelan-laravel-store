<?php
/**
 * @author Tonatiuh Flores Castelán
 * @version 1.0
 * @file ProductController
 */
namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product as Product;
use App\Category as Category;
use App\Http\Requests\StoreProduct;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * @method
     * @description
     * @return
     */
    public function index(Request $request)
    {
        $inputText      = $request->input('text');
        $dateStart      = $request->input('date_start');
        $dateEnd        = $request->input('date_end');

        $products   = Product::orderBy('name', 'ASC')
                    ->when($inputText, function ($query, $inputText) {
                        return $query->where('name', 'like', '%' . $inputText . '%')->orWhere('description', 'like', '%' . $inputText . '%');
                    })
                    ->when($dateStart, function ($query, $dateStart) {
                    return $query->where('created', '>=', $dateStart . ' 00:00:00');
                    })
                    ->when($dateEnd, function ($query, $dateEnd) {
                        return $query->where('created', '<=', $dateEnd . ' 23:59:59');
                    })
                    ->paginate();
        $categories = Category::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
    	return view('products.index', compact('categories', 'products', 'dateStart', 'dateEnd', 'inputText'));
    }

    /**
     * @method
     * @description
     * @return
     */
    public function create()
    {
        $selectOption   = array('' => 'Select a category');
        $categories     = Category::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $categories     = $selectOption + $categories;
        return view('products.create', compact('categories'));
    }

    /**
     * @method
     * @description
     * @return
     */
    public function store(StoreProduct $request)
    {
        $now = date('Y-m-d H:i:s');
        $product = Product::create(array_merge($request->all(), ['created' => $now]));

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully');
    }

    /**
     * @method
     * @description
     * @return
     */
    public function edit($id)
    {
        try {
            $product    = Product::findOrFail($id);
            $selectOption   = array('' => 'Select a category');
            $categories     = Category::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            $categories     = $selectOption + $categories;
        } catch (ModelNotFoundException $exception) { 
            return back()->withError($exception->getMessage());
        }
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * @method
     * @description
     * @return
     */
    public function update(Request $request, $id)
    {
        $now = date('Y-m-d H:i:s');
        $product = Product::findOrFail($id);
        $update = $product->fill(array_merge($request->all(), ['modified' => $now]))->save();

        return redirect()->route('products.index')->with('success', 'Product has been edited correctly');
    }

    /**
     * @method deleteProducts
     * @description
     * @return
     */
    public function deleteProducts(Request $request)
    {
        $response   = array();
        $ids        = $request->input('ids');

        if (!$ids) {
            $response = array(
                'success' => false,
                'message' => 'You must select at least one record',
            );
        } else {
            Product::whereIn('id', explode(",",$ids))->delete();
            $response = array(
                'success' => true,
                'message' => 'Products removed correctly',
            );
        }
        return response()->json($response, 200);
    }

    public function exportProducts()
    {
        $time           = time();
        Excel::create('products-' . $time, function($excel) {
         
            $contacts = Product::all();
         
            $excel->sheet('Product', function($sheet) use($contacts) {
                
                $sheet->row(1, [
                    'Name', 'Price', 'Description', 'Category', 'Create',
                ]);

                $sheet->cells('A1:E1', function ($cells) {
                    $cells->setBackground('#A7E2F2');
                    $cells->setAlignment('center');
                });

                $categories     = Category::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
                foreach($contacts as $index => $contact) {

                    $name               = !empty($contact->name) ? $contact->name : null;
                    $price              = !empty($contact->price) ? $contact->price : null;
                    $description        = !empty($contact->description) ? $contact->description : null;
                    $category           = !empty($contact->category_id) ? $categories[$contact->category_id] : null;
                    $createdAt          = !empty($contact->created) ? $contact->created : null;

                    $sheet->row($index+2, [
                        $name, $price, $description, $category, $createdAt
                    ]);
                }
            });
         
        })->export('xlsx');
    }
}