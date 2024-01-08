<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
    
        return response()->json($products, 200);
    }
    

    public function create_step1(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        return response()->json(['step1' => $validatedData], 200);
    }
    
    public function create_step2(Request $request)
    {
        $validatedData = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('images')) {
            $images = [];
    
            foreach ($request->file('images') as $image) {
                $uploadedImagePath = $image->store('public/images');
                $savedImagePath = str_replace('public/', 'storage/', $uploadedImagePath);
                $images[] = $savedImagePath;
            }
    
            return response()->json(['step2' => ['images' => $images]], 200);
        } else {
          
            return response()->json(['error' => 'No images were uploaded'], 400);
        }
    }
    
    public function create_step3(Request $request)
{
    $validatedData = $request->validate([
        'datetime' => 'required|date',
    ]);

    $step1Data = $request->input('step1');
    $step2Data = $request->input('step2');
    $images = $step2Data['images']; // Access 'images' array directly

    // Ensure $images is an array and not empty before proceeding
    // if (is_array($images) && !empty($images)) {
    //     // Saving images to the public directory
    //     $savedImagePaths = [];
    //     foreach ($images as $image) {
    //         // Store each image in the 'public/images' directory
    //         $uploadedImagePath = $image->store('public/images');
    //         $savedImagePath = str_replace('public/', 'storage/', $uploadedImagePath);
    //         $savedImagePaths[] = $savedImagePath;
    //     }
    // } else {
    //     // Handle case where no images were uploaded
    //     return response()->json(['error' => 'No images were uploaded'], 400);
    // }

    // Creating the Product
    $product = new Product();
    $product->name = $step1Data['name'];
    $product->category = $step1Data['category'];
    $product->description = $step1Data['description'];
    // $product->images = json_encode($savedImagePaths);
    $product->datetime = $validatedData['datetime'];

    $product->save();

    return response()->json(['message' => 'Product created successfully'], 201);
}


public function update_step1(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    return response()->json(['step1' => $validatedData], 200);
}

public function update_step2(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $validatedData = $request->validate([
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('images')) {
        $images = [];
        foreach ($request->file('images') as $image) {
            $uploadedImagePath = $image->store('public/images');
            $savedImagePath = str_replace('public/', 'storage/', $uploadedImagePath);
            $images[] = $savedImagePath;
        }
        $product->images = json_encode($images);
        $product->save();

        return response()->json(['message' => 'Step 2 updated successfully'], 200);
    } else {
        return response()->json(['error' => 'No images were uploaded'], 400);
    }
}

public function update_step3(Request $request, $id)
{
    try {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'step1.name' => 'required|string|max:255',
            'step1.category' => 'required|string|max:255',
            'step1.description' => 'required|string',
            'step2.images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'datetime' => 'required|date',
            // Add other fields if necessary
        ]);

        $step1Data = $request->input('step1');
        $step2Data = $request->input('step2');

        $product->name = $step1Data['name'];
        $product->category = $step1Data['category'];
        $product->description = $step1Data['description'];

        if ($request->hasFile('step2.images')) {
            $images = [];
            foreach ($request->file('step2.images') as $image) {
                $uploadedImagePath = $image->store('public/images');
                $savedImagePath = str_replace('public/', 'storage/', $uploadedImagePath);
                $images[] = $savedImagePath;
            }
            $product->images = json_encode($images);
        }

        $product->datetime = $validatedData['datetime'];
        $product->save();

        return response()->json(['message' => 'Product updated successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}




public function edit($id)
{
    $product = Product::findOrFail($id);
    return response()->json(['product' => $product], 200);
}



    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }


    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
    public function count()
    {
        $count = Product::count();
        return response()->json(['count' => $count], 200);
    }
}
