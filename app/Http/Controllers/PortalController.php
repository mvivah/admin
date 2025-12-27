<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        // Show links to client apps. If you want, include token generation for quick links (make short-lived)
        return view('portal.index', []);
    }
}
