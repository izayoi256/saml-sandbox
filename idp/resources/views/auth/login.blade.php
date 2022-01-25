@extends('layout/index')

@section('content')
    <form method="post" action="{{ route('login') }}">
        @csrf
        @samlidp
        <button type="submit">ログイン</button>
    </form>
@endsection
