<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SEOMeta;
use DB;
use Image;
use Storage;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $user = \Auth::user();
        $problems = DB::table('problems')->paginate(15);

        SEOMeta::setTitle("Профиль пользователя $user->name");

        return view('profile', ['user' => $user, 'problems' => $problems]);
    }

    public function update_profile(Request $request)
    {
        $user = DB::table('users')->where('id', $request->id);


        if($request->hasFile('img'))
        {
            $img = $request->file('img');

            $old_img = $user->value('avatar');

            $old_path = 'images/user/' . $old_img;

            $filename = 'user-' . $user->value('id') . '-' . time() . '.' . $img->getClientOriginalExtension();

            $thumb_path = public_path('images/user/' . $filename);

            Image::make($img->getRealPath())->fit(128, 128)->save($thumb_path);

            Storage::disk('public')->delete($old_path);
        }
        else
        {
            $filename = $user->value('avatar');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $filename,
        ]);

        return redirect()->route('profile');
    }
}
