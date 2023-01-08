<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homepage()
    {

        //imagine we loaded data from the DB
        $ourName = 'Wpstorm';
        $animals = ['Meowsalot', 'Batksalot', 'tigger'];

        return view('homepage', ['allAnimals' => $animals, 'name' => $ourName, 'catname' => 'Mewsalot']);
    }

    public function aboutPage()
    {
        return view('single-post');
    }
}
