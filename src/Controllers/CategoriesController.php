<?php

namespace Juanrube\Ticketit\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Juanrube\Ticketit\Helpers\LaravelVersion;
use Juanrube\Ticketit\Models\Category;

class CategoriesController extends Controller
{

    public function index()
    {
        // seconds expected for L5.8<=, minutes before that
        $time = 60 * 60;
        $categories = Cache::remember('ticketit::categories', $time, function () {
            return Category::all();
        });

        return view('ticketit::admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('ticketit::admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'color' => 'required',
        ]);

        $category = new Category;
        $category->create(['name' => $request->name, 'color' => $request->color]);

        Session::flash('status', trans('ticketit::lang.category-name-has-been-created', ['name' => $request->name]));

        Cache::forget('ticketit::categories');

        return redirect()->action('\Juanrube\Ticketit\Controllers\CategoriesController@index');
    }

    public function show($id)
    {
        return 'All category related agents here';
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('ticketit::admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'color' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name, 'color' => $request->color]);

        Session::flash('status', trans('ticketit::lang.category-name-has-been-modified', ['name' => $request->name]));

        Cache::forget('ticketit::categories');

        return redirect()->action('\Juanrube\Ticketit\Controllers\CategoriesController@index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();

        Session::flash('status', trans('ticketit::lang.category-name-has-been-deleted', ['name' => $name]));

        Cache::forget('ticketit::categories');

        return redirect()->action('\Juanrube\Ticketit\Controllers\CategoriesController@index');
    }
}
