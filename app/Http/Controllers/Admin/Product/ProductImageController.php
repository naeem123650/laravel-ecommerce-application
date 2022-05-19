<?php

namespace App\Http\Controllers\Admin\Product;

use App\Contracts\Admin\Product\ProductContract;
use App\Http\Controllers\Controller;
use App\Models\Admin\Product\ProductImage;
use App\Traits\Uploadable;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    use Uploadable;

    protected $productRepository;

    public function __construct(ProductContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function upload(Request $request)
    {
        $product = $this->productRepository->findProductById($request->product_id);

        if ($request->has('image')) {

            $image = $this->uploadOne($request->image, 'products/'.$product->id);

            $productImage = new ProductImage([
                'full'      =>  $image,
            ]);

            $product->images()->save($productImage);
        }
    }

    public function delete($id)
    {
        $image = ProductImage::findOrFail($id);

        if ($image->full != '') {
            $this->deleteOne($image->full);
        }

        $image->delete();

        return redirect()->back();
    }
}
