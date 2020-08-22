<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Work;
use App\History;
use Carbon\Carbon;

class WorkController extends Controller
{
    public function add()
    {
        return view('admin.work.create');
    }

    public function create(Request $request)
    {
        // Varidationを行う
      $this->validate($request, Work::$rules);

      $work = new Work;
      $work_form = $request->all();

      // フォームから参考資料が送信されてきたら、保存して、$work->file_path に参考資料のパスを保存する
      if (isset($work_form['file'])) {
        $path = $request->file('file')->store('public/file');
        $work->file_path = basename($path);
      } else {
          $work->file_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($work_form['_token']);
      // フォームから送信されてきたfileを削除する
      unset($work_form['file']);

      // データベースに保存する
      $work->fill($work_form);
      $work->save();

        return redirect('admin/work');
    }

    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            // 検索されたら検索結果を取得する
            $posts = Work::where('name', $cond_name)->get();
        } else {
            // それ以外はすべてのニュースを取得する
            $posts = Work::all();
        }
        return view('admin.work.index', ['posts' => $posts, 'cond_name' => $cond_name]);
    }

    public function edit(Request $request)
    {
        // WorkModelからデータを取得する
        $work = Work::find($request->id);
        if (empty($work)) {
            abort(404);
        }
        return view('admin.work.edit', ['work_form' => $work]);
    }


    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Work::$rules);
        // Work Modelからデータを取得する
        $work = Work::find($request->id);

        // 送信されてきたフォームデータを格納する
        $work_form = $request->all();
        if (isset($work_form['file'])) {
            $path = $request->file('file')->store('public/file');
            $work->file_path = basename($path);
            unset($work_form['file']);
        } elseif (0 == strcmp($request->remove, 'true')) {
            $work->file_path = null;
        }
        unset($work_form['_token']);
        unset($work_form['remove']);

        // 該当するデータを上書きして保存する
        $work->fill($work_form)->save();

        $history = new History;
        $history->work_id = $work->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/work');
    }

    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $work = Work::find($request->id);
        // 削除する
        $work->delete();
        return redirect('admin/work');
    }  
}
