@extends('layouts.app')

@section('title', 'Products - Creator Showcase')
@section('meta_description', 'Browse our collection of premium digital products created by talented individuals. Find templates, designs, courses and more.')

@section('content')
    <x-products.index-content 
        :products="$products" 
        :allTags="$allTags" 
        :popularTags="$popularTags"
    />
@endsection 