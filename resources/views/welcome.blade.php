@extends('layouts.app')

@section('title', setting('seo_title', 'Creator Showcase - Digital Products'))
@section('meta_description', setting('seo_description', 'Discover impressive digital products from talented creators. Browse and explore the best in the business.'))

@section('content')
    <x-welcome-content 
        :creator="$creator" 
        :products="$products ?? collect()" 
        :creatorsCount="$creatorsCount" 
        :productsCount="$productsCount" 
        :totalMrr="$totalMrr"
    />
@endsection
