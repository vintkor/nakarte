@extends('layouts.app')

@section('content')
    <div class="single-problem-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $problem->problems_title }}<br><small>{{ $problem->problems_address }}</small></h1>
                    <hr>
                    <div class="row">
                        <div class="col-md-8"><div id="map"></div></div>
                        <div class="col-md-4"><img class="img-responsive" src="//placehold.it/600x600" alt=""></div>
                    </div>
                    <hr>
                    <div class="col-md-12">{{ $problem->problems_long_desc }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script>
    ymaps.ready(function () {
        var coordinate = [{{ $problem->problems_lat }}, {{ $problem->problems_lng }}];
        var myMap = new ymaps.Map('map', {
                    center: coordinate,
                    zoom: 15
                }, {
                    searchControlProvider: 'yandex#search'
                }),
                myPlacemark = new ymaps.Placemark(myMap.getCenter(), {},{
                    // Опции.
                    // Необходимо указать данный тип макета.
                    iconLayout: 'default#image',
                    // Своё изображение иконки метки.
                    iconImageHref: '{{ asset('images/problems/markers' . '/' . $problem->problems_iconImageHref) }}',
                    // Размеры метки.
                    // Смещение левого верхнего угла иконки относительно
                    // её "ножки" (точки привязки).
                    iconImageSize: [36, 46],
                    iconImageOffset : [-18, -46]
                });

        myMap.geoObjects.add(myPlacemark);
    });
</script>
@endpush

@push('css')
<style>
    #map {
        height: 350px;
    }
</style>
@endpush