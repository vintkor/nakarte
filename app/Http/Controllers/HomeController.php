<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use DB;
use URL;

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
        $categories = DB::table('problem_categories')->get()->all();
        return view('home', ['categories' => $categories]);
    }

    public function ajax_all_problems()
    {
        $data_test = DB::table('problems')->get()->all();
        $data = [
            'type' => 'FeatureCollection'
        ];
//        dd($data_test);
        foreach ($data_test as $key => $value) {

            $balloonContentHeader = $data_test[$key]->problems_title . '<hr>';
            $category = DB::table('problem_categories')->find($data_test[$key]->problem_categories_id);
            $balloonContentBody = str_limit($data_test[$key]->problems_long_desc, 200, '...')
                                . '<br><a href="'
                                . URL::route('single_problem_get', $data_test[$key]->problems_slug)
                                . '" class="btn btn-sm btn-success pull-right">Больше информации</a><div class="clearfix"></div>';
            $coordinates = [$data_test[$key]->problems_lat, $data_test[$key]->problems_lng];
            $balloonContentFooter = '<hr>Адрес проблемы: '
                                    . $data_test[$key]->problems_address
                                    . '<br>Категория: '
                                    . $category->problem_categories_title;
            $iconImageHref = asset('images/problems/markers/' . $data_test[$key]->problems_iconImageHref);

            $data['features'][$key] = [
                'type' => 'Feature',
                'id' => $data_test[$key]->id,
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => $coordinates,
                ],
                'properties' => [
                    'balloonContentHeader' => $balloonContentHeader,
                    'balloonContentBody' => $balloonContentBody,
                    'balloonContentFooter' => $balloonContentFooter,
                    'clusterCaption' => 'Еще одна метка ' . $data_test[$key]->id,
                    'hintContent' => $data_test[$key]->problems_title,
                ],
                'options' => [
                    'iconLayout' => 'default#image',
                    'iconImageSize' => [36, 46],
                    'iconImageOffset'=> [-18, -46],
                    'iconImageHref' => $iconImageHref,
                ]
            ];
        }

        return response()->json($data);
    }

    public function ajax_categories_problems($id)
    {
        $data_test = DB::table('problems')->get()->where('problem_categories_id', $id)->all();
        $data = [
            'type' => 'FeatureCollection'
        ];

//        dd($data_test);

        $count = 0;
        foreach ($data_test as $key => $value) {


            $balloonContentHeader = $data_test[$key]->problems_title . '<hr>';
            $category = DB::table('problem_categories')->find($data_test[$key]->problem_categories_id);
            $balloonContentBody = str_limit($data_test[$key]->problems_long_desc, 200, '...')
                                . '<br><a href="'
                                . URL::route('single_problem_get', $data_test[$key]->problems_slug)
                                . '" class="btn btn-sm btn-success pull-right">Больше информации</a><div class="clearfix"></div>';
            $coordinates = [$data_test[$key]->problems_lat, $data_test[$key]->problems_lng];
            $balloonContentFooter = '<hr>Адрес проблемы: '
                . $data_test[$key]->problems_address
                . '<br>Категория: '
                . $category->problem_categories_title;
            $iconImageHref = asset('images/problems/markers/' . $data_test[$key]->problems_iconImageHref);

            $data['features'][$count] = [
                'type' => 'Feature',
                'id' => $data_test[$key]->problem_categories_id,
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => $coordinates,
                ],
                'properties' => [
                    'balloonContentHeader' => $balloonContentHeader,
                    'balloonContentBody' => $balloonContentBody,
                    'balloonContentFooter' => $balloonContentFooter,
                    'clusterCaption' => 'Еще одна метка ' . $data_test[$key]->id,
                    'hintContent' => $data_test[$key]->problems_title,
                ],
                'options' => [
                    'iconLayout' => 'default#image',
                    'iconImageSize' => [36, 46],
                    'iconImageOffset'=> [-18, -46],
                    'iconImageHref' => $iconImageHref,
                ]
            ];
            $count++;
        }

        return response()->json($data);
    }

    public function add_problems_get()
    {
        $categories = DB::table('problem_categories')->get()->all();
        return view('add_new_problem', ['categories' => $categories]);
    }

    public function add_problems_post(Request $request)
    {
        $problem_categories_id = $request->category; //id категории
        $problems_title = $request->shortDesc;       //Название
        $problems_address = $request->address . ' (' . $request->curentAddress . ')';       //Адрес
        $problems_long_desc = $request->longDesc;    //Полное описание
        $problems_lat = $request->lat;               //Координата-LAT
        $problems_lng = $request->lng;               //Координата-LNG
        $problems_slug = str_slug($problems_title . '_' . $request->address . '_' . $request->curentAddress);

        switch ($problem_categories_id){
            case 1: $problems_iconImageHref = 'maps-blue.png'; break;
            case 2: $problems_iconImageHref = 'maps-green.png'; break;
            case 3: $problems_iconImageHref = 'maps-red.png'; break;
            default: $problems_iconImageHref = 'maps-grey.png'; break;
        }

        DB::table('problems')->insert([
            'problem_categories_id' => $problem_categories_id,
            'users_id' => 0,
            'problems_title' => $problems_title,
            'problems_address' => $problems_address,
            'problems_short_desc' => $problems_title,
            'problems_long_desc' => $problems_long_desc,
            'problems_lat' => $problems_lat,
            'problems_lng' => $problems_lng,
            'problems_image' => '',
            'problems_video' => '',
            'problems_iconImageHref' => $problems_iconImageHref,
            'problems_active' => 1,
            'problems_slug' => $problems_slug
        ]);

        return redirect()->route('home');
    }

    public function single_problem_get($slug)
    {
        $temp = DB::table('problems')->where('problems_slug', $slug);
        $problem = $temp->first();
        SEOMeta::setTitle($temp->value('problems_title') . ' - ' . $temp->value('problems_address'));
        return  view('single_problem', ['problem' => $problem]);
    }

}
