<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_all_problems()
    {
        return view('home');
    }

    public function ajax_all_problems()
    {
        return response()->json([
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'id' => 0,
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            50.950540, 28.630888
                        ]
                    ],
                    'properties' => [
                        'balloonContentHeader' => 'Super Test',
                        'balloonContentBody' => '<a href="#">Содержимое</a> балуна 1',
                        'balloonContentFooter' => 'Footer content 1',
                        'clusterCaption' => 'Еще одна метка 1',
                        'hintContent' => 'Текст подсказки 1',
                    ],
                    'options' => [
                        'iconLayout' => 'default#image',
//                        'iconImageSize' => [34, 34],
//                        'iconImageHref' => 'maps-red.png',
                    ]
                ]
            ]
        ]);
    }
}
