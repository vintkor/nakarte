@extends('layouts.app')

@section('content')
    <div class="single-problem-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $problem->problems_title }}<br><small>{{ $problem->problems_address }}</small></h1>
                    <hr>
                    <div class="row">
                        @if(!empty($problem->problems_image))
                            <div class="col-md-8"><div id="map"></div></div>
                            <div class="col-md-4">
                                <a class="problem_image" href="{{ asset('images/problems/problems_images/large/' . $problem->problems_image) }}" data-lity>
                                <img class="img-responsive"
                                     src="{{ asset('images/problems/problems_images/medium/' . $problem->problems_image) }}" 
                                     alt="{{ $problem->problems_title . ' ' . $problem->problems_address }}">
                                </a>
                            </div>
                        @else
                            <div class="col-md-12"><div id="map"></div></div>
                        @endif
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <img src="{{ asset('images/theme-img/youtube.png') }}" style="position: relative; margin-top: -4px; margin-right: 5px;">
                            <a href="{{ $problem->problems_video }}" data-lity>Смотреть видео о проблеме</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">{{ $problem->problems_long_desc }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.2.0/lity.min.js"></script>
<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script>

    $(document).on('click', '[data-lightbox]', lity);

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.2.2/lity.min.css">
<style>
    #map {
        height: 300px;
    }
    .problem_image {
        position: relative;
        display: block;
        z-index: 1;
        transition: .2s;
        overflow: hidden;
    }
    .problem_image img {
        transition: .2s;
        transform: scale(1);
    }
    .problem_image:hover img {
        transform: scale(1.07);
    }
    .problem_image:after {
        position: absolute;
        display: block;
        content: '';
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0);
        z-index: 3;
        transition: .2s;
    }
    .problem_image:hover:after {
        background: rgba(0, 0, 0, 0.33);
    }
    .problem_image:before {
        position: absolute;
        display: block;
        content: '';
        top: 50%;
        left: 50%;
        width: 64px;
        height: 64px;
        margin-top: -32px;
        margin-left: -32px;
        z-index: 4;
        transition: .3s;
        transform: scale(0);
        background: url('data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ2My4wMDEgNDYzLjAwMSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDYzLjAwMSA0NjMuMDAxOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjY0cHgiIGhlaWdodD0iNjRweCI+CjxnPgoJPHBhdGggZD0iTTMwMy41MDEsMGMtODcuOTQ4LDAtMTU5LjUsNzEuNTUxLTE1OS41LDE1OS41YzAsMzYuMTg4LDEyLjEyMiw2OS41OTMsMzIuNTA3LDk2LjM4NmwtMzIuMzExLDMyLjMxMSAgIGMtMC4yMDUsMC4yMDUtMC4zOTIsMC40MjEtMC41NjksMC42NDNjLTIuNjQ1LTAuNTUxLTUuMzYzLTAuODQtOC4xMjctMC44NGMtMTAuNTUsMC0yMC40Nyw0LjEwOS0yNy45MzMsMTEuNTcybC05NS45OTksOTUuOTk5ICAgQzQuMTA4LDQwMy4wMywwLDQxMi45NDksMCw0MjMuNXM0LjEwOCwyMC40NzEsMTEuNTY4LDI3LjkyOEMxOS4wMzEsNDU4Ljg5MSwyOC45NTEsNDYzLDM5LjUwMSw0NjNzMjAuNDctNC4xMDksMjcuOTMzLTExLjU3MiAgIGw5NS45OTktOTUuOTk5YzcuNDYxLTcuNDU4LDExLjU2OS0xNy4zNzcsMTEuNTY5LTI3LjkyOWMwLTIuNzY1LTAuMjg5LTUuNDg0LTAuODQtOC4xMjljMC4yMjItMC4xNzYsMC40MzctMC4zNjMsMC42NDItMC41NjggICBsMzIuMzEtMzIuMzFDMjMzLjkwOCwzMDYuODc5LDI2Ny4zMTMsMzE5LDMwMy41MDEsMzE5Yzg3Ljk0OCwwLDE1OS41LTcxLjU1MSwxNTkuNS0xNTkuNVMzOTEuNDQ5LDAsMzAzLjUwMSwweiBNNTYuODI2LDQ0MC44MjIgICBDNTIuMTk3LDQ0NS40NTEsNDYuMDQ1LDQ0OCwzOS41MDEsNDQ4cy0xMi42OTYtMi41NDktMTcuMzI2LTcuMTc5QzE3LjU0OCw0MzYuMTk2LDE1LDQzMC4wNDUsMTUsNDIzLjVzMi41NDgtMTIuNjk2LDcuMTc2LTE3LjMyMiAgIGw4Ni42OTgtODYuNjk4bDM0LjY0NywzNC42NDdMNTYuODI2LDQ0MC44MjJ6IE0xNTQuMDc1LDM0My40NjhsLTM0LjUyOC0zNC41MjhjNC41NzUtMy45MzYsMTAuMjU4LTUuOTI2LDE1Ljk1NC01LjkyNiAgIGM2LjI3NCwwLDEyLjU1LDIuMzg5LDE3LjMyNiw3LjE2NmM0LjYyNyw0LjYyNSw3LjE3NSwxMC43NzYsNy4xNzUsMTcuMzIxQzE2MC4wMDIsMzMzLjQyNywxNTcuOTA2LDMzOS4wMjcsMTU0LjA3NSwzNDMuNDY4eiAgICBNMTY3LjczLDMwNC42NjVjLTEuMjc4LTEuNzk2LTIuNzA2LTMuNTAzLTQuMjk2LTUuMDkyYy0xLjU5Mi0xLjU5MS0zLjMwMS0zLjAyLTUuMDk4LTQuMjk5bDI3Ljg0MS0yNy44NDEgICBjMywzLjI1OSw2LjEzNCw2LjM5Myw5LjM5Myw5LjM5M0wxNjcuNzMsMzA0LjY2NXogTTMwMy41MDEsMzA0Yy03OS42NzgsMC0xNDQuNS02NC44MjItMTQ0LjUtMTQ0LjVTMjIzLjgyMywxNSwzMDMuNTAxLDE1ICAgczE0NC41LDY0LjgyMiwxNDQuNSwxNDQuNVMzODMuMTc5LDMwNCwzMDMuNTAxLDMwNHoiIGZpbGw9IiNGRkZGRkYiLz4KCTxwYXRoIGQ9Ik0zMDMuNTAxLDMyYy03MC4zMDQsMC0xMjcuNSw1Ny4xOTYtMTI3LjUsMTI3LjVTMjMzLjE5NywyODcsMzAzLjUwMSwyODdzMTI3LjUtNTcuMTk2LDEyNy41LTEyNy41UzM3My44MDUsMzIsMzAzLjUwMSwzMnogICAgTTMwMy41MDEsMjcyYy02Mi4wMzIsMC0xMTIuNS01MC40NjctMTEyLjUtMTEyLjVTMjQxLjQ2OSw0NywzMDMuNTAxLDQ3czExMi41LDUwLjQ2NywxMTIuNSwxMTIuNVMzNjUuNTMzLDI3MiwzMDMuNTAxLDI3MnoiIGZpbGw9IiNGRkZGRkYiLz4KCTxwYXRoIGQ9Ik0zNTUuNTgsNzkuNDM4Yy0zLjQ3LTIuMjYyLTguMTE2LTEuMjgzLTEwLjM3OCwyLjE4OGMtMi4yNjIsMy40Ny0xLjI4Miw4LjExNywyLjE4OCwxMC4zNzggICBjMjIuOTI0LDE0Ljk0LDM2LjYxLDQwLjE3MiwzNi42MSw2Ny40OTZjMCwxOC42NjctNi41MzQsMzYuODYtMTguMzk5LDUxLjIyNmMtMi42MzgsMy4xOTMtMi4xODcsNy45MjEsMS4wMDcsMTAuNTU5ICAgYzEuMzk4LDEuMTU1LDMuMDksMS43MTcsNC43NzIsMS43MTdjMi4xNiwwLDQuMzA0LTAuOTI5LDUuNzg3LTIuNzI0YzE0LjA3OS0xNy4wNDcsMjEuODMzLTM4LjYzMiwyMS44MzMtNjAuNzc3ICAgQzM5OS4wMDEsMTI3LjA4NywzODIuNzY5LDk3LjE1OCwzNTUuNTgsNzkuNDM4eiIgZmlsbD0iI0ZGRkZGRiIvPgoJPHBhdGggZD0iTTMyMC44NTYsNjUuNTc1QzMxNS4xNjgsNjQuNTMsMzA5LjMyOSw2NCwzMDMuNTAxLDY0Yy00LjE0MywwLTcuNSwzLjM1OC03LjUsNy41czMuMzU3LDcuNSw3LjUsNy41ICAgYzQuOTIyLDAsOS44NDksMC40NDcsMTQuNjQ1LDEuMzI4YzAuNDU5LDAuMDg0LDAuOTE0LDAuMTI1LDEuMzY0LDAuMTI1YzMuNTQ5LDAsNi43MDMtMi41MzEsNy4zNjgtNi4xNDYgICBDMzI3LjYyNiw3MC4yMzMsMzI0LjkzLDY2LjMyNCwzMjAuODU2LDY1LjU3NXoiIGZpbGw9IiNGRkZGRkYiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K') no-repeat center center;
    }
    .problem_image:hover:before {
        transition: .3s;
        transform: scale(1.3);
    }
</style>
@endpush