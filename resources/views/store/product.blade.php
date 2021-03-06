@extends('layouts.store') 

@section('title', $producto->nombre)

@section('extra-css')

@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Inicio</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <a href="{{ route('shop.index') }}">Shop</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>{{ $producto->nombre }}</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="product-section container">
        <div class="product-section-image">
            <img src="{{ asset('img/productos/'.$producto->foto) }}" alt="product">
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{ $producto->nombre }}</h1>
 
            @if($oferta->idproducto == $producto->idproducto)

                <div class="product-section-subtitle">{{ $producto->detalles }}</div>
                <div class="product-section-price"><p style="color:#239B56";>$ {{$producto->precio}}</p> </div>
                <div class="product-section-subtitle" style="color:red";>$ {{$oferta->descuento}}</div>
                <div class="product-name">{{ $oferta->descripcion }}</div>
    


                @else
                    <div class="product-section-subtitle">{{ $producto->detalles }}</div>
                    <div class="product-section-price" style="color:#239B56";>${{ $producto->precio }}</div>
                    <p>{{ $producto->descripcion }}</p>
            @endif

            <p>&nbsp;</p>

            <form action="{{ route('cart.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $producto->idproducto }}">
                <input type="hidden" name="name" value="{{ $producto->nombre }}">
                <input type="hidden" name="price" value="{{ $producto->precio }}">
                <button type="submit" class="button button-plain">Add to Cart</button>
            </form>
        </div>
    </div> <!-- end product-section -->

    @include('partes.might-like')


@endsection
