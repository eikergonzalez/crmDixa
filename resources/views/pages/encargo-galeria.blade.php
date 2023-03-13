@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="fa-fa-arrow-left block-title">
                    <a class="nav-main-link" href="/encargo">
                        <i class="nav-main-link-icon far fa fa-arrow-left"></i>
                        <span class="nav-main-link-name"> Encargo - Galería</span>
                    </a> 
                </h3>
            </div>
            <div class="block-content">
                <div class="row items-push js-gallery img-fluid-100">
                    @foreach($galeria as $image)
                        <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
                            <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="{{ asset($image->patch) }}">
                                <img class="img-fluid" src="{{ asset($image->patch) }}" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
