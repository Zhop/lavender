@extends('core::layouts.master')

@section('head.title') Homepage @stop

@section('header')
    <div class="menu">
        <a href="/">Lavender</a>
        <ul>
            @foreach(Lavender\Catalog\Category::all() as $category)
                <li><a href="{{ URL::to('category/id/'.$category->id) }}">{{ $category->name }}</a></li>
            @endforeach
            <li>
                <a href="{{ URL::to('pos/cart') }}">Cart ({{ count(Lavender\Crm\User::find(1)->get()[0]->cart->items) }} items)</a>
            </li>
        </ul>
    </div>
@stop

@section('content')
    Wow it's some amazing default content.
@stop