<?php

// Главная
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Главная', route('home'));
});

// Главная > Новости
//Breadcrumbs::register('news', function($breadcrumbs)
//{
//    $breadcrumbs->parent('home');
//    $breadcrumbs->push('Новости', route('news'));
//});

// Главная > Профиль пользователя
Breadcrumbs::register('profile', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Профиль пользователя ' . Auth::user()->name, route('profile'));
});


//Breadcrumbs::register('single_news', function($breadcrumbs, $news) {
//    $breadcrumbs->parent('news');
//    $breadcrumbs->push($news->title, route('single_news', $news->id));
//});