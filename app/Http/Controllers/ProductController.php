<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Get a list of products",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="401", description="Unauthorized"),
     * )
     * @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     * )
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get a product by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Product not found"),
     * )
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create a new product",
     *     security={{"bearerAuth":{}}},
     *        @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number", format="float"),
     *         )
     *     ),
     *     @OA\Response(response="201", description="Product created"),
     *     @OA\Response(response="400", description="Bad request"),
     *     @OA\Response(response="401", description="Unauthorized"),
     * )
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }


    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Update a product by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true, 
     *           @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number", format="float"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Product updated successfully"),
     *     @OA\Response(response="400", description="Bad request"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Product not found"),
     * )
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Delete a product by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Product deleted successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Product not found"),
     * )
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/products/by-date/{date}",
     *     summary="Get products by date",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="date",
     *         in="path",
     *         required=true,
     *         description="Date in the format YYYY-MM-DD",
     *         @OA\Schema(type="string", format="date"),
     *     ),
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Products not found"),
     * )
     */
    public function getProductsByDate($date)
    {
        // Convert the date to the correct format (optional)
        $formattedDate = \Carbon\Carbon::parse($date)->format('Y-m-d');

        // Query products based on the created date
        $products = Product::whereDate('created_at', '=', $formattedDate)->get();

        return response()->json($products);
    }

    /**
     * @OA\Get(
     *     path="/api/products/by-name/{name}",
     *     summary="Get products by name",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         required=true,
     *         description="Name of the product",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Products not found"),
     * )
     */

    public function getProductsByName($name)
    {
        $products = Product::where('name', 'like', "%$name%")->get();
        return response()->json($products);
    }
}
