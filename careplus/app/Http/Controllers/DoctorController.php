<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('dashboard.find_doctor', compact('doctors'));
    }

    public function dashboard()
    {
        $doctors = Doctor::all(); // Fetch all available doctors
        $appointments = Appointment::where('user_id', Auth::id())->get(); // Fetch user-specific appointments

        return view('dashboard', compact('doctors', 'appointments'));
    }
}
