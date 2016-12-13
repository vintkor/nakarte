@extends('layouts.app')

@push('scripts')
<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script>
    ymaps.ready()
            .done(function (ym) {
                var myMap = new ym.Map('map', {
                    center: [50.942691, 28.619817],
                    controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
                });

                function loadMy(defaultData) {
                    jQuery.getJSON(defaultData, function (json) {
                        var geoObjects = ym.geoQuery(json).applyBoundsToMap(myMap, {checkZoomRange: false});
                        var result = ym.geoQuery(json).applyBoundsToMap(myMap, {checkZoomRange: true});
                        myMap.geoObjects.add(result.clusterize());
                    });
                }

                var defauldData = "{{ URL::route('ajax_all_problems') }}";

                loadMy(defauldData);

                $('.data-group').each(function() {
                    $(this).click(function() {
                        $('.data-group').removeClass('green');
                        myMap.geoObjects.removeAll();

                        var dataValue = $(this).attr('data-problem-location');

                        $(this).addClass('green');
                        loadMy(dataValue);
                    });
                });

            });
</script>
@endpush

@push('css')
<style>
    #map {
        width: 100%;
        height: 500px;
        padding: 0;
        margin: 0;
    }
    .navbar {
        margin: 0;
    }
</style>
@endpush

@section('content')

<div id="map"></div>
<hr>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
