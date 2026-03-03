<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Store a new RSVP guest entry.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'jumlah_hadir' => 'required|integer|min:1|max:10',
            'status_hadir' => 'required|in:hadir,tidak',
            'pesan' => 'nullable|string|max:500',
        ]);

        $guest = Guest::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'RSVP berhasil disimpan!',
            'data' => $guest,
        ], 201);
    }

    /**
     * Get the last 10 guest entries for the guestbook.
     */
    public function index(): JsonResponse
    {
        $guests = Guest::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $guests,
        ]);
    }
}
