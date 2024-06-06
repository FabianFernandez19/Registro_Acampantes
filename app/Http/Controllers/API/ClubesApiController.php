<?php

namespace App\Http\Controllers\API;
use App\Models\Clubes;
use App\Models\Distritos;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClubesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        $user = Auth::user();
        $clubes = Clubes::with('distrito')->get();
        return response()->json($clubes, 200);
    }*/
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Administrator')) {
            $clubes = Clubes::with('distrito')->get();
        } else {
            $clubes = $user->clubes()->with('distrito')->get();
        }
        
        return response()->json($clubes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'distrito_id' => 'required|exists:distritos,id',
        ]);

        $clubes = new Clubes();
        $clubes->nombre = $request->nombre;
        $clubes->distrito_id = $request->distrito_id;
        $clubes->user_id = Auth::id(); // Obtiene el ID del usuario autenticado
        $clubes->save();

        return response()->json(['message' => 'Club creado exitosamente', 'club' => $clubes], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function show($id)
    {
        $user = Auth::user();
        $clubes = Clubes::find($id);
        return response()->json($clubes,200);
    }*/

    public function show($id)
{
    $user = Auth::user();
    $clubes = Clubes::find($id);

    // Verificar si el club existe y pertenece al usuario autenticado
    if ($clubes && ($user->hasRole('Administrator') || $user->id === $clubes->user_id)) {
        return response()->json($clubes, 200);
    } else {
        return response()->json(['message' => 'No autorizado para ver este club'], 403);
    }
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'distrito_id' => 'required|exists:distritos,id',
        ]);

        $clubes = Clubes::findOrFail($id);
        $clubes->nombre = $request->nombre;
        $clubes->distrito_id = $request->distrito_id;
        $clubes->user_id = Auth::id(); // Obtiene el ID del usuario autenticado
        $clubes->save();

        return response()->json(['message' => 'Club actualizado exitosamente', 'club' => $clubes], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clubes = Clubes::find($id);
        if($clubes){
        $clubes->delete();
        return response()->json($clubes, 200);
    }else{
        return response()->json(['message' => 'club no encontrado'], 404);
    }
    }
}
