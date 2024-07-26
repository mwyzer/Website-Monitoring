<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() 
    {
        $ip = '192.168.1.100'; // Move to env or config for security
        $user = 'admin';       // Move to env or config for security
        $pass = 'admin';       // Move to env or config for security

        $API = new RouterosAPI();
        $API->debug = false;  // Boolean value

        if($API->connect($ip, $user, $pass)) {
            $identity = $API->comm('/system/identity/print');
            $router_model = $API->comm('/system/identity/print');
            return view('dashboard', compact('identity'));
        } else {
            return response()->json(['error' => 'Bad Connection'], 500);
        }

        $data = [
            'identity' => $identity[0]['name'],
            'model' => $router_model[0]['model']
        ];

        // dd($identity);

        return view('dashboard', $data);
    }
}
