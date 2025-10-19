<?php

namespace App\Http\Controllers\Coiffeur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoifDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('coiffeur.coifdash'); // crée la vue ci‑dessous
    }
}
