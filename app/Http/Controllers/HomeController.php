<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
        $data_test = [];
        $data_test = DB::table('problems')->get()->all();
        $data = [
            'type' => 'FeatureCollection',
            'features' => []
        ];
        foreach ($data_test as $key => $value) {
            $data['features'][$key] = [
                'type' => 'Feature',
                'id' => $data_test[$key]->id,
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        $data_test[$key]->problems_lat, $data_test[$key]->problems_lng
                    ]
                ],
                'properties' => [
                    'balloonContentHeader' => $data_test[$key]->problems_title,
                    'balloonContentBody' => $data_test[$key]->problems_short_desc,
                    'balloonContentFooter' => 'footer content-' . $data_test[$key]->id,
                    'clusterCaption' => 'Еще одна метка 1' . $data_test[$key]->id,
                    'hintContent' => $data_test[$key]->problems_title,
                ],
                'options' => [
                    'iconLayout' => 'default#image',
//                        'iconImageSize' => [34, 34],
//                        'iconImageHref' => 'maps-red.png',
                ]
            ];
        }

        return response()->json($data);
    }

    public function add_problems_get()
    {
        return view('add_new_problem');
    }

}
