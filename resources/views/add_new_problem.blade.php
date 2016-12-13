@extends('layouts.app')

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
        min-height: 131px ;
    }
    p.bg-info {
        padding: 5px;
        background: #C1EAFE;
        border-radius: 5px;
    }
    label.required {
        position: relative;
    }
    label.required:after {
        content: ' *';
        color: #d22;
    }
</style>
@endpush

@section('content')

<div id="map"></div>
<hr>
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>korosten.nakarte.in.ua</h1>
                <h2>Добавление новой проблемы на карту города Коростень</h2>
                <hr>
                <p class="bg-info">Кликните мышкой по карте и в этом месте появится маркер. Передвигайте этот маркер таким образом, чтобы его ножка находилась на нужном месте в центре городской проблемы, после чего, заполните форму ниже.</p>
                <div class="row">
                        <form action="" method="get">
                            <input name="lat" type="hidden" id="lat" value="">
                            <input name="lng" type="hidden" id="lng" value="">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="required">Адрес</label>
                                    <input name="address" type="text" id="address" value="" class="form-control" required  placeholder="Кликните по карте">
                                </div>
                                <div class="form-group">
                                    <label for="curentAddress">Уточните местоположение</label>
                                    <input name="curentAddress" type="text" id="curentAddress" value="" class="form-control" placeholder="Например: На пешеходном переходе">
                                </div>
                                <div class="form-group">
                                    <label for="shortDesc" class="required">Краткое название проблемы</label>
                                    <input name="shortDesc" type="text" id="shortDesc" value="" class="form-control" required placeholder="Например: Выбоина на пешеходном переходе">
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longDesc" class="required">Расширенное описание, суть проблемы</label>
                                    <textarea name="longDesc" id="longDesc" class="form-control" required placeholder="Например: Выбоина на пешеходном переходе размером 1,5 на 2 метра. Пройти в час пик невозможно"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="category" class="required">Категория</label>
                                    <select id="category" class="form-control">
                                        <option disabled selected >Выберите категорию</option>
                                        <option name="">skfjhdkjffjkd</option>
                                        <option name="">skfjhdkjdsfsdfsffjkd</option>
                                        <option name="">skfjhdfhfghfgkjffjkd</option>
                                        <option name="">rtrt45dfftd</option>
                                        <option name="">skfj67345xfgfhdkjffjkd</option>
                                    </select>
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
