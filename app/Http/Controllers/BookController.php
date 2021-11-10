<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Yajra\Datatables\Datatables;
use Ramsey\Uuid\Uuid;

class BookController extends Controller
{
    public function index()
    {
        return view('books.index');
    }
    public function datatables()
    {
        $books = Book::with(['categories'])->get();
        return Datatables::of($books)
            ->addIndexColumn()
            ->addColumn('image', function ($item) {
                $url = asset('storage/' . $item->cover);
                return '<img src="' . $url . '" border="0" width="100" height="80"  align="center" />';
            })
            ->addColumn('action', function ($item) {
                $categories = [];
                foreach ($item->categories as $c) {
                    $categories[] = $c->name;
                }
                if (count($categories) >  1) {
                    $book_categories = implode(", ", $categories);
                } else {
                    $book_categories = $categories[0];
                }

                return '
                   <a href="' . url('book/edit/' . $item->slug) . '" class="btn btn-sm btn-warning">Edit</a>
                   <button type="button" id="btnDetailBook" class="btn btn-info btn-sm" data-toggle="modal" data-target="#DetailBookModal"
                   book_title="' . $item->title . '" 
                   book_author="' . $item->author . '"
                   book_categories="' . $book_categories . '"
                   book_price="' . $item->price . '"
                   book_cover="' . $item->cover . '"
                   book_publisher="' . $item->publisher . '"
                   book_stock="' . $item->stock . '"
                   book_description="' . $item->description . '"
                   >
                    Detail
                    </button>
                   <button type="button" id="btnDeleteBook" book_id="' . $item->id . '" book_name="' . $item->title . '" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteBookModal">
                    Delete
                    </button>
                ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
    public function create()
    {
        return view('books.create');
    }
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'publisher' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required'
        ]);
        $book = new Book;
        $image_path = $request->file('image')->store('books', 'public');
        $book->id = Uuid::uuid4()->getHex();
        $book->title = $request->title;
        $book->slug = \Str::slug($request->title, '-');
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->price = $request->price;
        $book->stock = $request->stock;
        $book->cover = $image_path;
        $book->description = $request->description;
        $book->save();
        $book->categories()->attach($request->get('category_id'));
        return redirect('/books')->with('message', 'New book successfully created');
    }
    public function edit($slug)
    {
        $book = Book::where('slug', '=', $slug)->firstOrFail();

        return view('books.edit', compact('book'));
    }
    public function update(Request $request)
    {
        $book = Book::findOrFail($request->id);
        $rules = [
            'title' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|numeric|min:0',
            'publisher' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required'
        ];
        if ($request->file('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg|max:1024';
            $this->validate($request, $rules);
            $book->title = $request->title;
            $book->slug = \Str::slug($request->title, '-');
            $book->author = $request->author;
            $book->publisher = $request->publisher;
            $book->price = $request->price;
            $book->stock = $request->stock;
            $book->description = $request->description;
            if (file_exists(storage_path('app/public/' . $book->cover))) {
                \Storage::delete('public/' . $book->cover);
            }
            $new_image = $request->file('image')->store('books', 'public');
            $book->cover = $new_image;
            $book->update();
            $book->categories()->sync($request->category_id);
        } else {
            $this->validate($request, $rules);
            $book->title = $request->title;
            $book->slug = \Str::slug($request->title, '-');
            $book->author = $request->author;
            $book->publisher = $request->publisher;
            $book->price = $request->price;
            $book->stock = $request->stock;
            $book->description = $request->description;
            $book->update();
            $book->categories()->sync($request->category_id);
        }

        return redirect('/book/edit/' . $book->slug)->with('message', 'Book successfully updated');
    }
    public function delete(Request $request)
    {
        $book = Book::findOrFail($request->delete_book_id);
        if (file_exists(storage_path('app/public/' . $book->cover))) {
            \Storage::delete('public/' . $book->cover);
        }
        $book->categories()->detach();
        $book->delete();
        return redirect('/books')->with('message', "$book->title successfully deleted");
    }
}
