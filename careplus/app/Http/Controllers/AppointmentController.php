<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'appointment_date' => 'required|date',
        ]);

        // Save the appointment to the database
        Appointment::create([
            'user_id' => Auth::id(), // Logged-in user ID
            'doctor_id' => $request->doctor_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'appointment_date' => $request->appointment_date,
        ]);

        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Appointment made successfully.');
    }

    /**
     * Cancel an appointment.
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ensure the logged-in user owns the appointment
        if ($appointment->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        $appointment->delete();

        return redirect()->route('dashboard')->with('success', 'Appointment canceled successfully.');
    }
}
