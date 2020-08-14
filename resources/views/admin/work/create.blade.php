{{-- layouts/work.blade.phpを読み込む --}}
@extends('layouts.work')


{{-- admin.blade.phpの@yield('title')に'職務経歴作成画面'を埋め込む --}}
@section('title', '職務経歴作成画面')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>職務経歴作成</h2>
            </div>
        </div>
    </div>
@endsection