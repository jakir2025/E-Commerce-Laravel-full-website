<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Ensure you import Str for slug generation

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function subCategoryCreate()
    {
        $categories = Category::all();
        // Logic to show the form for creating a new sub-category
        return view('backend.subcategory.create', compact('categories'));
    }
    public function subCategoryStore(Request $request)
    {
      $subCategory = new SubCategory();

        $subCategory->name = $request->name;
        $subCategory->slug = str::slug($request->name);
        $subCategory->cat_id = $request->cat_id;

        $subCategory->save();
        return redirect()->back()->with('success', 'Sub-category created successfully.');
    }

    public function subCategoryList()
    {
        $subCategories = SubCategory::with('category')->get();
        // Logic to show the list of sub-categories
        return view('backend.subcategory.list', compact('subCategories'));
    }
    public function subCategoryDelete($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();
        return redirect()->back()->with('success', 'Sub-category deleted successfully.');
    }
    public function subCategoryEdit($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $categories = Category::all();
        // Logic to show the form for editing a sub-category
        return view('backend.subcategory.edit', compact('subCategory', 'categories'));
    }
    public function subCategoryUpdate(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->cat_id = $request->cat_id;

        $subCategory->save();
        return redirect('admin/sub-category/list')->with('success', 'Sub-category updated successfully.');
    }
}