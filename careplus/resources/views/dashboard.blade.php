<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <!-- Available Doctors Section -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg">Available Doctors</h3>
                    <ul>
                        @foreach ($doctors as $doctor)
                        <li class="mt-2">
                            <div>
                                @if ($doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->name }}" style="width:50px; height:50px; object-fit:cover;">
                                @endif
                                <span>{{ $doctor->name }} - {{ $doctor->specialization }}</span>
                            </div>
                            <form method="POST" action="{{ route('appointments.store') }}" class="mt-2">
                                @csrf
                                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                <input type="text" name="name" placeholder="Your Name" required>
                                <input type="tel" name="phone" placeholder="Your Phone" required>
                                <input type="datetime-local" name="appointment_date" required>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Make Appointment</button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Your Appointments Section -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg">Your Appointments</h3>
                    @if ($appointments->isEmpty())
                    <p>No appointments yet.</p>
                    @else
                    <ul>
                        @foreach ($appointments as $appointment)
                        <li class="mt-2">
                            @if ($appointment->doctor) <!-- Check if doctor exists -->
                            <span>Doctor: {{ $appointment->doctor->name }}</span> <br>
                            @else
                            <span>Doctor information unavailable</span> <br> <!-- Fallback text if doctor is null -->
                            @endif
                            <span>On: {{ $appointment->appointment_date }}</span> <!-- Appointment date -->
                            <span>{{ $appointment->appointment_time }}</span> <!-- Appointment time -->
                            <form method="POST" action="{{ route('appointments.destroy', $appointment->id) }}" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>