<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $total = User::count();
        $todayActive = 0;

        $todayNew = User::whereDate('created_at', date('Y-m-d'))->count();
        $mainUsers = User::pluck('uuid');
        $loggedIn = UserDevice::whereIn('user_id', $mainUsers)->where('token', '!=', '')->distinct('user_id')->count();

        $iosTraffic = UserDevice::whereIn('user_id', $mainUsers)->where('device_name', 'ios')->count();
        $androidTraffic = UserDevice::whereIn('user_id', $mainUsers)->where('device_name', 'android')->count();

        return view('panel-v1.index', compact('todayActive', 'total', 'todayNew', 'mainUsers', 'loggedIn', 'iosTraffic', 'androidTraffic'));
    }

    public function users(Request $request)
    {


        $users = User::latest()->paginate(20);

        if ($request->ajax()) {

            $query = $request->input('query');

            $users = User::query();
            if ($query) {
                $users = $users->where('name', 'like', '%' . $query . '%')->orWhere('email', 'like', '%' . $query . '%');
            }
            $users = $users->latest()->Paginate(20);
            return view('panel-v1.user.user-ajax', compact('users'));
        }
        return view('panel-v1.user.index', compact('users'));
    }

    public function exportCSV()
    {

        $users = User::select('name', 'phone_number','country','payment_method')->get();
        $columns = ['name', 'phone_number','country','payment_method'];

        $handle = fopen(storage_path('users.csv'), 'w');

        fputcsv($handle, $columns);

        foreach ($users->chunk(2000) as $chunk) {
            foreach ($chunk as $user) {
                fputcsv($handle, $user->toArray());
            }
        }

        fclose($handle);

        return response()->download(storage_path('users.csv'))->deleteFileAfterSend(true);
    }

    public function approveUser($user_id){
        $user = User::find($user_id);
        if($user){
            $user->status = 1;
            $user->save();
        }
        return redirect()->back();
    }
}
