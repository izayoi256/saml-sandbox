@extends('layout/index')

@section('content')
    <h1>
        idp
        ({{ $_SERVER['HTTP_HOST'] }})
    </h1>
    <form method="post" action="{{ route('login') }}">
        @csrf
        @samlidp
        <button type="submit">ログイン</button>
    </form>
@endsection
