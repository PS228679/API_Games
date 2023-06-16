<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        Log::info('register', ['ip' => $request->ip(), 'data' => $request->all()]);

        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email']
        ]);

        return response()->json(['message' => 'Registration successful'], 200);
    }


    public function login(Request $request)
    {
        Log::info('login', ['ip' => $request->ip(), 'data' => $request->all()]);

        $attr = $request->only([
            'email',
            'password'
        ]);

        Log::info('attr:', $attr);

        if (!Auth::attempt($attr)) {
            Log::info('Login failed');
            return $this->error('Credentials not match', 401);
        }
        $response = [
            // 'access_token' => $request->bearerToken(),
            'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer'
        ];
        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        Log::info('logout', ['ip' => $request->ip(), 'data' => $request->all(), 'user' => auth()->user()]);

        auth()->user()->tokens()->delete();
        return [
            'message' => 'Tokens Revoked'
        ];
    }

    public function index(Request $request)
    {
        $request->user()->currentAccessToken()->delete();    // Verwijder de actuele token

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
            $data =  Game::orderBy($request->sort)->get();
        } else {
            $data = Game::all();
            // $data = Werknemer::with('functie')->get();
        }
        $content = [
            'success' => true,
            'data'    => $data,
            'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ];
        return response()->json($content, 200);
    }

    public function store(Request $request)
    {
        $request->user()->currentAccessToken()->delete();    // Verwijder de actuele token
        Log::info(
            'games store',
            [
                'ip' => $request->ip(),
                'data' => $request->all(),
            ]
        );
        $validator = Validator::make($request->all(), [
            'email' => 'email',
            'naam' => 'required'
        ]);
        if ($validator->fails()) {
            Log::error("Game toevoegen Fout");
            $content = [
                'success' => false,
                'data'    => $request->all(),
                'foutmelding' => 'Data niet correct',
                'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
                'token_type' => 'Bearer',
            ];
            return response()->json($content, 400);
        } else {
            $content = [
                'success' => true,
                'data'    => Game::create($request
                    ->only(['naam', 'functie_id', 'telefoon', 'email', 'sinds'])),
                'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
                'token_type' => 'Bearer',
            ];
            return response()->json($content, 201);
        }
    }

    public function show(Request $request, Game $game)
    {
        $request->user()->currentAccessToken()->delete();    // Verwijder de actuele token

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
            'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ];
        return response()->json($content, 200);
    }

    public function update(Request $request, Game $game)
    {
        $request->user()->currentAccessToken()->delete();    // Verwijder de actuele token

        Log::info(
            'games update',
            ['ip' => $request->ip(), 'oud' => $game, 'nieuw' => $request->all()]
        );

        $validator = Validator::make($request->all(), [
            'naam' => 'required',
            'email' => 'email',
        ]);
        if ($validator->fails()) {
            Log::error("games wijzigen Fout");
            $content = [
                'success' => false,
                'data'    => $request->all(),
                'foutmelding' => 'Gewijzigde data niet correct',
                'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
                'token_type' => 'Bearer',
            ];
            return response()->json($content, 400);
        } else {
            $content = [
                'success' => $game->update($request->all()),
                'data'    => $request->only(['naam', 'functie_id', 'telefoon', 'email', 'sinds']),
                'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
                'token_type' => 'Bearer',
            ];
            return response()->json($content, 200);
        }
    }

    public function destroy(Request $request, Game $game)
    {
        $request->user()->currentAccessToken()->delete();    // Verwijder de actuele token

        Log::info(
            'games destroy',
            ['ip' => $request->ip(), 'oud' => $game]
        );
        $game->delete();

        $content = [
            'success' => true,
            'data'    => $game,
            'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ];
        return response()->json($content, 202);
    }

    public function indexFunctie(Request $request, $id)
    {
        $request->user()->currentAccessToken()->delete();    // Verwijder de actuele token

        Log::info(
            'games indexFunctie',
            [
                'ip' => $request->ip(),
                'data' => $request->all(),
                'id' => $id
            ]
        );
        if ($request->has('sort')) {
            $data =  Game::where('functie_id', $id)->orderBy($request->sort)->get();
        } else {
            $data = Game::where('functie_id', $id)->get();
        }

        $content = [
            'success' => true,
            'data'    => $data,
            'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ];
        return response()->json($content, 200);
    }

    public function destroyFunctie(Request $request, $id)
    {
        $request->user()->currentAccessToken()->delete();    // Verwijder de actuele token

        Log::info(
            'games destroyFunctie',
            [
                'ip' => $request->ip(),
                'data' => $request->all(),
                'functie id' => $id
            ]
        );
        Game::where('functie_id', $id)->delete();

        $content = [
            'success' => true,
            'data'    => $id,
            'access_token' => auth()->user()->createToken('API Token')->plainTextToken,
            'token_type' => 'Bearer',
        ];
        return response()->json($content, 202);
    }

    public function error(String $error, int $statusCode) {
        return response()->json($error, $statusCode);
    }
}
