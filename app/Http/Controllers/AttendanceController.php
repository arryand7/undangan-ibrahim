<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display attendance list with form and summary.
     */
    public function index(Request $request)
    {
        $query = Attendance::orderBy('created_at', 'desc');

        // Filter by pihak if specified
        if ($request->filled('filter_pihak')) {
            $query->where('pihak', $request->filter_pihak);
        }

        $attendances = $query->get();

        // Summary statistics
        $summary = [
            'total_tamu' => Attendance::count(),
            'total_nominal' => Attendance::sum('nominal'),
            'pria' => [
                'total_tamu' => Attendance::where('pihak', 'pria')->count(),
                'total_nominal' => Attendance::where('pihak', 'pria')->sum('nominal'),
            ],
            'wanita' => [
                'total_tamu' => Attendance::where('pihak', 'wanita')->count(),
                'total_nominal' => Attendance::where('pihak', 'wanita')->sum('nominal'),
            ],
        ];

        return view('attendance.index', compact('attendances', 'summary'));
    }

    /**
     * Store a new attendance record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'pihak' => 'required|in:pria,wanita',
            'nominal' => 'nullable|integer|min:0',
        ]);

        // Default nominal to 0 if not provided
        $validated['nominal'] = $validated['nominal'] ?? 0;

        Attendance::create($validated);

        return redirect()->route('attendance.index')
            ->with('success', 'Tamu berhasil dicatat!');
    }

    /**
     * Delete an attendance record.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Data tamu berhasil dihapus.');
    }
}
