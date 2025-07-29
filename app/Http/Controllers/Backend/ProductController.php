<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\GalleryImage;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct() // ✅ ঠিক করা হয়েছে
    {
        $this->middleware('auth');
    }

    public function productCreate()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $subCategories = SubCategory::orderBy('name', 'asc')->get();
        return view('backend.product.create', compact('categories', 'subCategories'));
    }

    public function productStore(Request $request)
    {
        $product = new Product();

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->cat_id = $request->cat_id;
        $product->sub_cat_id = $request->sub_cat_id;
        $product->sku_code = $request->sku_code;
        $product->quantity = $request->quantity;
        $product->buying_price = $request->buying_price;
        $product->regular_price = $request->regular_price;
        $product->discount_price = $request->discount_price;
        $product->product_type = $request->product_type;
        $product->description = $request->description;
        $product->product_policy = $request->product_policy;

        if (isset($request->image)) {
            $imageName = rand() . '.' . $request->image->extension();
            $request->image->move('backend/images/products/', $imageName);
            $product->image = $imageName;
        }

        $product->save();

        //add color
        if(isset($request->color_name) && $request->color_name[0] != null) {

            foreach($request->color_name as $singleColor) {
                 $color = new Color();
                 $color->color_name = $singleColor;
                 $color->slug = Str::slug($singleColor);
                 $color->product_id = $product->id;
                 $color->save();

            }


        }
        //add size

        if(isset($request->size_name) && $request->size_name[0] != null) {

            foreach($request->size_name as $singleSize) {
                 $size = new Size();
                 $size->size_name = $singleSize;
                 $size->slug = Str::slug($singleSize);
                 $size->product_id = $product->id;
                 $size->save();

            }
         }
        //add gallery images

        if(isset($request->gallery_image)){
            foreach($request->gallery_image as $singleImage){
                $galleryImage = new GalleryImage();

                $galleryImage->product_id = $product->id;
                $galleryImageName = rand() .'-galleryImage-'.'.' . $singleImage->extension();
                $singleImage->move('backend/images/galleryimages/', $galleryImageName);
                $galleryImage->image = $imageName;
                $galleryImage->save();
            }
        }

        return redirect()->back()->with('success', 'Product added successfully');
    }

    public function productList()
    {
        $products = Product::with('category', 'subCategory',)->get();
        return view('backend.product.list', compact('products'));
    }

    public function productDelete($id)
    {
        $product = Product::findOrFail($id);

         // Delete product images
        if($product->image && file_exists('backend/images/products/' . $product->image)) {
            unlink('backend/images/products/' . $product->image);
        }

        // Delete colors
        $colors = Color::where('product_id', $product->id)->get();
        foreach ($colors as $color) {
            $color->delete();
        }

        // Delete associated sizes
        $sizes = Size::where('product_id', $product->id)->get();
        foreach ($sizes as $size) {
            $size->delete();
        }
        // Delete gallery images
        $galleryImages = GalleryImage::where('product_id', $product->id)->get();

        foreach ($galleryImages as $galleryImage) {
            if($galleryImage->image && file_exists('backend/images/galleryimages/' . $galleryImage->image)) {
                unlink('backend/images/galleryimages/' . $galleryImage->image);
            }
            $galleryImage->delete();
        }

        //finally delete the product
          $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');
    }

    public function productEdit($id)
    {
        $product = Product::where('id', $id)->with('color', 'size', 'galleryImage')->first();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        return view('backend.product.edit', compact('product', 'categories', 'subCategories'));
    }

    public function productUpdate(Request $request, $id){

        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->cat_id = $request->cat_id;
        $product->sub_cat_id = $request->sub_cat_id;
        $product->sku_code = $request->sku_code;
        $product->quantity = $request->quantity;
        $product->buying_price = $request->buying_price;
        $product->regular_price = $request->regular_price;
        $product->discount_price = $request->discount_price;
        $product->product_type = $request->product_type;
        $product->description = $request->description;
        $product->product_policy = $request->product_policy;

        if (isset($request->image)) {
            if ($product->image && file_exists('backend/images/products/' . $product->image)) {
                unlink('backend/images/products/' . $product->image);
            }
            $imageName = rand() .'-productup-'. '.' . $request->image->extension();
            $request->image->move('backend/images/products', $imageName);
            $product->image = $imageName;
        }
            $product->save();

        // Update colors
        if(isset($request->color_name) && $request->color_name > [0] != null) {
            $colors = Color::where('product_id', $product->id)->get(); // Clear existing colors
            foreach($colors as $singleColor) {
                    $singleColor->delete(); // Delete existing colors
        
            foreach($request->color_name as $singleColor) {
                 $color = new Color();
                 $color->color_name = $singleColor;
                 $color->slug = Str::slug($singleColor);
                 $color->product_id = $product->id;
                 $color->save();
            }
        }

        // Update sizes
        if(isset($request->size_name) && $request->size_name > [0] != null) {
            $sizes = Size::where('product_id', $product->id)->get(); // Clear existing sizes
            foreach($sizes as $singleSize) {
                $singleSize->delete(); // Delete existing sizes
            }
            foreach($request->size_name as $singleSize) {
                    $size = new Size();
                    $size->size_name = $singleSize;
                    $size->slug = Str::slug($singleSize);
                    $size->product_id = $product->id;
                    $size->save();
            }
         }

         // Update gallery images
         if(isset($request->gallery_image)){
            // Delete existing gallery images
            $galleryImages = GalleryImage::where('product_id', $product->id)->get();
            foreach($galleryImages as $singleImage) {
                if($singleImage->image && file_exists('backend/images/galleryimages/' . $singleImage->image)) {
                    unlink('backend/images/galleryimages/' . $singleImage->image);
                }
                 // Delete the gallery image record
                $singleImage->delete();
            }
             foreach($request->gallery_image as $singleImage){
                 $galleryImage = new GalleryImage();
                 $galleryImage->product_id = $product->id;
                
                 $galleryImageName = rand() .'-galleryImage-'.'.' . $singleImage->extension();
                 $singleImage->move('backend/images/galleryimages', $galleryImageName);

                 $galleryImage->image = $galleryImageName;
                 $galleryImage->save();
             }
         }

        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully');
    }
  }
        // Delete color, size, and gallery image methods
         public function colorDelete($id)
          {
          $color = Color::findOrFail($id);
          $color->delete();
          return redirect()->back()->with('success', 'Color deleted successfully');
         }

         public function sizeDelete($id)
            {
            $size = Size::findOrFail($id);
            $size->delete();
            return redirect()->back()->with('success', 'Size deleted successfully');
            }

        public function galleryImageDelete($id)
        {
            $galleryImage = GalleryImage::findOrFail($id);

            if ($galleryImage->image && file_exists('backend/images/galleryimage/' . $galleryImage->image)) {
                unlink('backend/images/galleryimage/' . $galleryImage->image);
            }
            $galleryImage->delete();
            return redirect()->back()->with('success', 'Gallery image deleted successfully');
        }

        public function galleryImageEdit($id)
        {
            $galleryImage = GalleryImage::with('product')->where('id', $id)->first();
            // $galleryImage = GalleryImage::findOrFail($id);
            return view('backend.product.edit-gallery', compact('galleryImage'));
        }



        public function galleryImageUpdate(Request $request, $id)
        {
            $galleryImage = GalleryImage::findOrFail($id);

            if (isset($request->image)) {
                if ($galleryImage->image && file_exists('backend/images/galleryimages/' . $galleryImage->image)) {
                    unlink('backend/images/galleryimages/' . $galleryImage->image);
                }
                $imageName = rand() . '-galleryImage-' . '.' . $request->image->extension();
                $request->image->move('backend/images/galleryimages', $imageName);
                $galleryImage->image = $imageName;
            }

            $galleryImage->save();
            return redirect('/admin/product/edit/' . $galleryImage->product_id)->with('success', 'Gallery image updated successfully');
        }

  
}
