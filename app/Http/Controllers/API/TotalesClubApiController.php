<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clubes;
use App\Models\Acampantes;
use App\Models\TotalesClub;
class TotalesClubApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalesclub = TotalesClub::all();
        return response()->json($totalesclub, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $totalesclub = TotalesClub::find($id);
        return response()->json($totalesclub,200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function calcularTotales($clubId)
{
    // Obtener el club y sus acampantes
    $club = Clubes::findOrFail($clubId);
    $acampantes = $club->acampantes;


 // Array asociativo de tarifas por distrito
 $tarifasPorDistrito = [
    'DISTRITO LA BRICHA' => 50000,
    'DISTRITO CAPITANEJO' => 50000,
    'DISTRITO SAN ANDRES' => 50000,
    'DISTRITO MALAGA' => 50000,
    'BARBOSA CENTRAL' => 50000,
    'DISTRITO BARBOSA EMANUEL' => 50000,
    'BARBOSA NORTE' => 50000,
    'DISTRITO GUAVATA' => 50000,
    'DISTRITO PUENTE NACIONAL' => 50000,
    'DISTRITO VELEZ' => 50000,
    'DISTRITO ARATOCA' => 50000,
    'DISTRITO SAN GIL' => 50000,
    'DISTRITO GALAN' => 50000,
    'DISTRITO SION SAN GIL' => 50000,
    'DISTRITO SOCORRO' => 50000,
];


    // Inicializar el total del club y el total de acampantes
    $totalClub = 0;
    $totalAcampantes = count($acampantes);

    // Calcular el total para cada acampante
    foreach ($acampantes as $acampante) {
        // Obtener el nombre del distrito del club
        $nombreDistrito = optional($club->distrito)->nombre; // Usamos optional() para manejar posibles valores nulos

        // Obtener la tarifa según el distrito del club
        $tarifa = $tarifasPorDistrito[$nombreDistrito] ?? 60000; // Usamos 60000 como valor predeterminado si el distrito no se encuentra en el array

        // Verificar si el cargo es "Economo"
    if ($acampante->tipo_entrada != "Economo") {
    // Calcular el total para el acampante
      $totalClub += $tarifa;
}

    }

    // Crear o actualizar la entrada en la tabla totales_club
    $totalesClub = TotalesClub::updateOrCreate(
        ['club_id' => $clubId],
        ['total_acampantes' => $totalAcampantes, 'total_club' => $totalClub]
    );

    // Devolver la respuesta JSON con los resultados
    return response()->json([
        'totales_club' => $totalesClub,
        'club' => $club,
        'acampantes' => $acampantes,
        'totalClub' => $totalClub,
    ]);
}


}
