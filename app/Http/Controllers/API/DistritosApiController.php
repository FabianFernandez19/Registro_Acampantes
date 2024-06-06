<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distritos;

class DistritosApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $distritos = Distritos::all();
        return response()->json($distritos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $distritos = new Distritos();
        $distritos->nombre =$request->nombre;
        $distritos->save();
        return response()->json($distritos, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $distritos = Distritos::find($id);
        return response()->json($distritos,200);
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
        $distritos = Distritos::find($id);
    
        // Verificar si el club fue encontrado
        if (!$distritos) {
            return response()->json(['message' => 'Distrito no encontrado'], 404);
        }
    
        // Si el club existe, actualiza sus propiedades
        $distritos->nombre = $request->$distritos;
        $$distritos->update();
    
        return response()->json($distritos, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $distritos = Distritos::find($id);
        if($distritos){
        $distritos->delete();
        return response()->json($distritos, 200);
    }else{
        return response()->json(['message' => 'Distriro no encontrado'], 404);
    }
    }
}
