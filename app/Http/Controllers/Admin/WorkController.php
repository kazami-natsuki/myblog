<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkController extends Controller
{
    public function add()
    {
        return view('admin.work.create');
    }

    public function create(Request $request)
    {
        return redirect('admin/work/create');
    }

    public function edit()
    {
        return view('admin.work.edit');
    }

    public function update()
    {
        return redirect('admin/work/edit');
    }
}
