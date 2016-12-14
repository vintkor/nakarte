@extends('layouts.app')

@section('content')

<div id="map"></div>
<hr>
<div class="my-btn-group">
    <button class="data-group btn btn-success" data-problem-location="ajax_all_problems">
        Все &rarr;
        <span class="badge">
            {{ DB::table('problems')->get()->count() }}
        </span>
    </button>
    @foreach($categories as $category)
        <button class="data-group btn" data-problem-location="ajax_categories_problems/{{ $category->id }}">
            {{ $category->problem_categories_title }} &rarr;
            <span class="badge">
                {{ DB::table('problems')->get()->where('problem_categories_id', $category->id)->count() }}
            </span>
        </button>
        @endforeach
</div>
<hr>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <a href="{{ URL::route('add_problems') }}">Добавить новый маркер</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


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
                        $('.data-group').removeClass('btn-success');
                        myMap.geoObjects.removeAll();

                        var dataValue = $(this).attr('data-problem-location');

                        $(this).addClass('btn-success');
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
    .my-btn-group {
        text-align: center;
    }
    .data-group {
        /*padding: 7px 15px;*/
        /*border: 1px solid #ACACAC;*/
        transition: .2s;
    }
    .data-group:hover {
        cursor: pointer;
    }
    .data-group:focus {
        outline: none;
    }
    .my-btn-group .btn:hover,
    .my-btn-group .btn-success:focus {
        color: #ffffff;
        background-color: #18bc9c;
        border-color: #18bc9c;
    }
    /*.green {*/
    /*background: #18BC9C;*/
    /*color: #fff;*/
    /*border: 1px solid #149b81;*/
    /*}*/
    ymaps hr {
        margin: 5px 0;
    }
</style>
@endpush
