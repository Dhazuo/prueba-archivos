<?php

namespace App\Http\Controllers;

use App\Imports\ParticipantsImport;
use App\Models\Participant;
use App\Models\Participation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ParticipationController extends Controller
{
    public function upload(Request $request)
    {
        $uuid = $request->get('uuid');
        if ($request->hasFile('multimedia')) {
            $file = $request->file('multimedia');
            $extension = $file->getClientOriginalExtension();
            $fileName = $uuid . "." . $extension;
            $path = storage_path('app/public/multimedia/');

            $file->move($path, $fileName);

            $participation = Participation::create([
                'uuid' => $uuid,
                'file_name' => $fileName,
                'file_path' => "multimedia/$fileName"
            ]);

            return response()->json([
                'uuid' => $participation->uuid
            ]);
        }
    }

    public function excel (Request $request, $participation)
    {

        $participation = Participation::where('uuid', $participation)->firstOrFail();

        if ($participation) {
            $csrf = csrf_token();
            return Inertia::render('Participation', compact('csrf'));
        }

    }

    public function uploadExcel(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            Excel::import(new ParticipantsImport, $file);

            $users = Participant::get();
            return response()->json([
                'users' => $users
            ]);
        }
    }
}
