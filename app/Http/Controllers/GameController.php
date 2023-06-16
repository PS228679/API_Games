<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Haal alle games op
    public function index(Request $request)
    {
        Log::info(
            'games index',
            [
                'ip' => $request->ip(),
                'data' => $request->all()
            ]
        );

        if ($request->has('naam')) {
            $data = Game::where('naam', 'like', '%' . $request->naam . '%')->get();
        } else if ($request->has('sort')) {
            $data = Game::orderBy($request->sort)->get();
        } else {
            $data = Game::all();
        }

        $content = [
            'success' => true,
            'data' => $data,
        ];

        return response()->json($content, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info(
            'games store',
            [
                'ip' => $request->ip(),
                'data' => $request->all(),
            ]
        );
        $validator = Validator::make($request->all(), [
            'naam' => 'required',
            'release_date' => 'required',
        ]);
        if ($validator->fails()) {
            Log::error("games toevoegen Fout");
            $content = [
                'success' => false,
                'data'    => $request->all(),
                'foutmelding' => 'Data niet correct',
            ];
            return response()->json($content, 400);
        } else {
            $content = [
                'success' => true,
                'data'    => Game::create($request
                    ->only(['naam', 'dev_id', 'release_date', 'platform'])),
            ];

            Log::info('Content: ', $content);
            return response()->json($content, 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show (Request $request, Game $game)
    {
        Log::info(
            'games show',
            [
                'ip' => $request->ip(),
                'data' => $request->all()
            ]
        );

        $content = [
            'success' => true,
            'data'    => $game,
        ];
        return response()->json($content, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        Log::info(
            'games update',
            ['ip' => $request->ip(), 'oud' => $game, 'nieuw' => $request->all()]
        );

        $validator = Validator::make($request->all(), [
            'naam' => 'required',
            'release_date' => 'email',
        ]);
        if ($validator->fails()) {
            Log::error("games wijzigen Fout");
            $content = [
                'success' => false,
                'data'    => $request->all(),
                'foutmelding' => 'Gewijzigde data niet correct',
            ];
            return response()->json($content, 400);
        } else {
            $content = [
                'success' => $game->update($request->all()),
                'data'    => $request->only(['naam', 'dev_id', 'release_date', 'platform']),
            ];
            return response()->json($content, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Game $game)
    {
        Log::info(
            'games destroy',
            ['ip' => $request->ip(), 'oud' => $game]
        );
        $game->delete();

        $content = [
            'success' => true,
            'data'    => $game,
        ];
        return response()->json($content, 202);

    }
    
    public function indexDeveloper(Request $request, $id)
    {
        Log::info(
            'games indexDeveloper',
            [
                'ip' => $request->ip(),
                'data' => $request->all(),
                'id' => $id
            ]
        );
        if ($request->has('sort')) {
            $data =  Game::where('dev_id', $id)->orderBy($request->sort)->get();
        } else {
            $data = Game::where('dev_id', $id)->get();
        }

        $content = [
            'success' => true,
            'data'    => $data,
        ];
        return response()->json($content, 200);
    }

    public function destroyFunctie(Request $request, $id)
    {
        Log::info(
            'games destroyFunctie',
            [
                'ip' => $request->ip(),
                'data' => $request->all(),
                'dev_id' => $id
            ]
        );
        Game::where('dev_id', $id)->delete();

        $content = [
            'success' => true,
            'data'    => $id,
        ];
        return response()->json($content, 202);
    }


}
