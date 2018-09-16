@extends('layouts.app')

@section('title', 'List')

@section('content')
    @if (count($products) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Товар</th>
                    <th scope="col">Продано, шт</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$product->title}}</td>
                    <td>{{$product->sales}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-danger col-md-4 offset-md-4" role="alert">
            К сожалению ничего не найдено...
        </div>
    @endif
@endsection
