<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function list($type)
    {
        $list = Category::where('type', $type)->where('parent_id', null)->get();
        return view('panel-v1.category.list', compact('list','type'));
    }

    public function create(Request $request)
    {
        $create = new Category();
        $create->name = $request->name;
        $create->type = $request->type;
        $create->save();
        return redirect()->back();
    }
    public function edit(Request $request, $id)
    {
        $find = Category::find($id);
        $find->name = $request->name;
        $find->save();
        return redirect()->back();
    }

    public function delete($id)
    {
        $find = Category::find($id);
        if ($find) {
            $find->delete();
        }
        return redirect()->back();
    }
    public function sub($id) {
        $list = Category::where('type', 'employment')->where('parent_id', $id)->get();
        $category = Category::find($id);
        return view('panel-v1.category.sub-list', compact('list','category'));
    }

    public function subCreate(Request $request)
    {
        $create = new Category();
        $create->name = $request->name;
        $create->type = $request->type;
        $create->parent_id = $request->parent_id;
        $create->save();
        return redirect()->back();
    }
}
