<?php
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
namespace App\Domains\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Product\Interfaces\ProductServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Domains\Product\Models\Product;


class ProductController extends Controller
{
    public $productService;
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $productList = $this->productService->getCompleteList();
        return view('product::product.index', ['products' => $productList]);        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('product::product.addProduct');
    }    
    public function store(Request $request)
    {
        $this->validate($request, [
                'name' => 'required|unique:products|max:24|alpha:ascii',
                'price' => 'required|integer',
                'description' => 'required|max:50'
        ]);
        $productArray = array(
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'status' => 1
        );
        $result = $this->productService->saveProductList($productArray);
        echo "Product saved successfully.";
    }
    public function show($id)
    {
        $productShow = $this->productService->getById($id);
        return view('product::product.editProduct', ['product' => $productShow]);
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
        $productArray = array(
           'name' => $request->name,
           'price' => $request->price, 
           'description' => $request->description,
           'status' => 1
        );       
        $this->productService->update($productArray, $id);
        echo "Updated product successfully";
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productService->delete($id);
        $productList = $this->productService->getCompleteList();
        return view('product::product.index', ['products' => $productList]);
    }
}
            