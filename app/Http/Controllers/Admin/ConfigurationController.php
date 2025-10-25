<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.config.index', compact('categories'));
    }

//
    public function changeCategoryStatus($categotyId)
    {
        $category = Category::find($categotyId);
        if ($category) {
            if ($category->status == 'hiện') {
                $category->update(['status' => 'ẩn']);
            } elseif ($category->status == 'ẩn') {
                $category->update(['status' => 'hiện']);
            }
        }
        return redirect()->route('admin.config.index')->with('success', 'Cập nhật trạng thái danh mục thành công.');
    }
}
