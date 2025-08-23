<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function Termwind\render;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function categoryCreate()
    {
        // Logic to show the category creation form
        return view('backend.category.create');
    }

    // You can add more methods here for handling categories, like store, edit, update, delete, etc.

    public function categoryStore(Request $request)
    {
        $category = new Category();

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->image = $request->image;

        if(isset($request->image)){
            $imageName = rand().'-category'.'.'.$request->image->extension();
            $request->image->move('backend/images/category/', $imageName);

            $category->image = $imageName;
        }

        $category->save();
        return redirect('/admin/category/list');

    }
    public function categoryList()
    {
        $categories = Category::all();
        // dd($categories);
        return view('backend.category.list', compact('categories'));
    }
    public function categoryDelete($id)
    {
        $category = Category::findOrFail($id);
         
        if($category->image && file_exists('backend/image/category/'.$category->image)){
            unlink('backend/image/category/'.$category->image);
        }

        // dd($category);
        $category->delete();
         toastr()->success('Data has been saved successfully!');
        return redirect()->back();
    }
    public function categoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.category.edit', compact('category'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if(isset($request->image)){

            if($category->image && file_exists('backend/images/category/'.$category->image)){
                unlink('backend/images/category/'.$category->image);
            }

            $imageName = rand().'-category'.'.'.$request->image->extension();
            $request->image->move('backend/images/category/', $imageName);
            
            $category->image = $imageName;
        }

        $category->save();
         toastr()->success('Data has been saved successfully!');
        return redirect('/admin/category/list');
    }
}
