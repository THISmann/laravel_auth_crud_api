<?php
// app/GraphQL/Resolvers/ProductResolver.php
namespace App\GraphQL\Resolvers;

use App\Models\Product;

class ProductResolver
{
    public function products()
    {
        return Product::all();
    }

    public function product($root, $args)
    {
        return Product::find($args['id']);
    }

    public function createProduct($root, $args)
    {
        return Product::create($args);
    }

    public function updateProduct($root, $args)
    {
        $product = Product::find($args['id']);
        if ($product) {
            $product->update($args);
            return $product;
        }
        return null;
    }

    public function deleteProduct($root, $args)
    {
        $product = Product::find($args['id']);
        if ($product) {
            $product->delete();
            return $product;
        }
        return null;
    }
}
