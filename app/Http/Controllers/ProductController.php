<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view("products.products", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("products.addProduct");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $messages = [
            'name.required' => 'The product name is required.',
            'name.unique' => 'The product name has already been taken.',
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'unit_price.required' => 'The product price is required.',
            'unit_price.numeric' => 'The product price must be a number.',
            'category.required' => 'The category is required.',
            'category.string' => 'The category must be a string.',
            'description.string' => 'The description must be a string.',
        ];

        $rules = [
            'name' => 'required|string|max:255|unique:products,name',
            'unit_price' => 'required|numeric',
            'category' => 'required|string',
            'description' => 'string',
        ];

        // Validation
        $this->validate($request, $rules, $messages);

        // Create a new product instance and save to the database
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('unit_price');
        $product->category = $request->input('category');
        $product->description = $request->input('description');
        $product->save();

        Alert::toast('Product created successfully!', 'success');
        // Redirect or return a response
        return redirect()->route('products')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view("products.editProduct", compact("product"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Custom error messages
        $messages = [
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'unit_price.required' => 'The product price is required.',
            'unit_price.numeric' => 'The product price must be a number.',
            'category.required' => 'The category is required.',
            'category.string' => 'The category must be a string.',
            'description.string' => 'The description must be a string.',
        ];

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'unit_price' => 'required|numeric',
            'category' => 'required|string',
            'description' => 'nullable|string', // Make description optional
        ];

        // Validation
        $this->validate($request, $rules, $messages);

        // Update the product's attributes
        $product->name = $request->input('name');
        $product->price = $request->input('unit_price');
        $product->category = $request->input('category');
        $product->description = $request->input('description');

        // Save the updated product
        $product->save();

        Alert::toast('Product updated successfully!', 'success');
        // Redirect or return a response
        return redirect()->route('products')->with('success', 'Product updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the product from the database
        $product->delete();

        Alert::toast('Product deleted successfully!', 'success');
        // Redirect to the product index with a success message
        return redirect()->route('products')->with('success', 'Product deleted successfully!');
    }
}
