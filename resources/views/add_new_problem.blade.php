@extends('layouts.app')

@section('content')


<div id="map"></div>
<hr>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {!! Breadcrumbs::render('add_problems') !!}            
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- <h1>korosten.nakarte.in.ua</h1> --}}
            <h2>Добавление новой проблемы на карту города</h2>
            <hr>
            <div class="alert alert-dismissible alert-success">
                <p>Кликните мышкой по карте и в этом месте появится маркер. Передвигайте этот маркер таким образом, чтобы его ножка находилась на нужном месте в центре городской проблемы, после чего, заполните форму ниже.</p>
            </div>
            <div class="alert alert-dismissible alert-warning">
                <p>Поля отмеченные звёздочкой являются обязательными к заполнению!</p>
            </div>
            <div class="row">
                <form action="" method="post" enctype="multipart/form-data">
                    <input name="lat" type="hidden" id="lat">
                    <input name="lng" type="hidden" id="lng">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="required">Адрес</label>
                            <input name="address" type="text" id="address" class="form-control" required  placeholder="Кликните по карте">
                        </div>
                        <div class="form-group">
                            <label for="curentAddress">Уточните местоположение</label>
                            <input name="curentAddress" type="text" id="curentAddress" class="form-control" placeholder="Например: На пешеходном переходе">
                        </div>
                        <div class="form-group">
                            <label for="shortDesc" class="required">Краткое название проблемы</label>
                            <input name="shortDesc" type="text" id="shortDesc" class="form-control" required placeholder="Например: Выбоина на пешеходном переходе">
                        </div>
                        <div class="form-group my-form-image">
                            <label for="image">Изображение</label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="you-tube">Адрес страницы YouTube с видео</label>
                            <input type="text" id="you-tube" name="you-tube" class="form-control" placeholder="https://www.youtube.com/watch?v=DEesOWwBsYw">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category" class="required">Категория</label>
                            <select name="category" id="category" class="form-control">
                                <option disabled selected >Выберите категорию</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->problem_categories_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="longDesc" class="required">Расширенное описание, суть проблемы</label>
                            <textarea name="longDesc" id="longDesc" class="form-control" required placeholder="Например: Выбоина на пешеходном переходе размером 1,5 на 2 метра. Пройти в час пик невозможно"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input name="submit" type="submit" class="btn btn-success">                                
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



@push('scripts')
<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
<script>
    ymaps.ready(init);

    function init() {
        var myPlacemark,
                myMap = new ymaps.Map('map', {
                    center: [50.942691, 28.619817],
                    zoom: 14
                });

        // Слушаем клик на карте.
        myMap.events.add('click', function (e) {
            var coords = e.get('coords');

            // Если метка уже создана – просто передвигаем ее.
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }
            // Если нет – создаем.
            else {
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                // Слушаем событие окончания перетаскивания на метке.
                myPlacemark.events.add('dragend', function () {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
            }
            getAddress(coords);
        });

        // Создание метки.
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });

        }

        // Определяем адрес по координатам (обратное геокодирование).
        function getAddress(coords) {
            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);

                $('#lat').val(coords[0]);
                $('#lng').val(coords[1]);
                $('#address').val(firstGeoObject.properties.get('name'));

                myPlacemark.properties
                        .set({
                            iconCaption: firstGeoObject.properties.get('name'),
                            balloonContent: firstGeoObject.properties.get('text')
                        });
            });
        }
    }
</script>
@endpush

@push('css')
<style>
    #map {
        width: 100%;
        height: 400px;
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
        padding: 7px 15px;
        border: 1px solid #ACACAC;
        transition: .2s;
    }
    .data-group:hover {
        cursor: pointer;
    }
    .data-group:focus {
        outline: none;
    }
    .green {
        background: #71BE32;
        color: #fff;
        border: 1px solid #5A9F22;
    }
    textarea.form-control {
        min-height: 303px ;
    }
    p.bg-info {
        padding: 3px;
        background: #DBF2FD;
        border-radius: 5px;
        border: 1px solid #C1DEEC;
    }
    p.bg-danger {
        padding: 3px;
        background: #FEFCE1;
        border-radius: 5px;
        border: 1px solid #F2EFC6;
    }
    label.required {
        position: relative;
    }
    label.required:after {
        content: ' *';
        color: #d22;
    }
/*    .my-form-image input {
        display: none;
    }
    .my-form-image label:after {
        content: 'Выберите изображение';
        position: relative;
        display: block;
        width: 100%;
        height: 45px;
        border-radius: 5px;
        border: 2px solid #dce4ec;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        top: 4px;
    }*/
</style>
@endpush
