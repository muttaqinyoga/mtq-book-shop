<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\Datatables\Datatables;
use Auth;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }
    public function datatables()
    {
        $categories = Category::orderBy('name')->get();
        return Datatables::of($categories)
            ->addIndexColumn()
            ->addColumn('image', function ($item) {
                $url = asset('storage/' . $item->image);
                return '<img src="' . $url . '" border="0" width="100" height="80"  align="center" />';
            })
            ->addColumn('action', function ($item) {
                return '
                   <a href="' . url('categories/edit/' . $item->slug) . '" class="btn btn-sm btn-warning">Edit</a>
                   <button type="button" id="btnDeleteCategory" category_id="' . $item->id . '" category_name="' . $item->name . '" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteCategoryModal">
                    Delete
                    </button>
                ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:30',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ]);
        $category = new Category;
        $category->name = $request->name;
        $category->slug = \Str::slug($request->name, '-');
        if ($request->file('image')) {
            $image_path = $request->file('image')->store('categories', 'public');
            $category->image = $image_path;
        }
        $category->created_by = Auth::user()->id;
        $category->save();
        return redirect('/categories')->with('message', 'New category successfully created');
    }
    public function edit($slug)
    {
        $category = Category::where('slug', '=', $slug)->firstOrFail();

        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $rules = ['name' => 'required|string|min:3|max:30'];
        if ($request->file('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg|max:1024';
            $this->validate($request, $rules);
            $category->name = $request->name;
            $category->slug = \Str::slug($request->name, '-');
            if ($category->image && file_exists(storage_path('app/public/' . $category->image))) {
                \Storage::delete('public/' . $category->image);
            }
            $new_image = $request->file('image')->store('categories', 'public');
            $category->image = $new_image;
            $category->updated_by = Auth::user()->id;
        } else {
            $this->validate($request, $rules);
            $category->name = $request->name;
            $category->slug = \Str::slug($request->name, '-');
            $category->updated_by = Auth::user()->id;
        }
        $category->update();
        return redirect('/categories/edit/' . $category->slug)->with('message', 'Category successfully updated');
    }
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        if (file_exists(storage_path('app/public/' . $category->image))) {
            \Storage::delete('public/' . $category->image);
        }
        $category->delete();
        return redirect('/categories')->with('message', "$category->name successfully deleted");
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q');
        if ($keyword) {
            $categories = Category::where("name", "LIKE", "%$keyword%")->get();
        } else {
            $categories = Category::orderBy("name")->get();
        }

        return $categories;
    }
}
