<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clubes;
use App\Models\Acampantes;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\StreamedResponse;

class AcampantesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acampantes = Acampantes::all();
        return response()->json($acampantes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $acampantes = new Acampantes();
        $acampantes->tipo_entrada =$request->tipo_entrada;
        $acampantes->cargo=$request->cargo;
        $acampantes->nombre_completo=$request->nombre_completo;
        $acampantes->email=$request->email;
        $acampantes->tipo_sangre=$request->tipo_sangre;
        $acampantes->tipo_documento_identificacion=$request->tipo_documento_identificacion;
        $acampantes->numero_identificacion=$request->numero_identificacion;
        $acampantes->fecha_nacimiento=$request->fecha_nacimiento;
        $acampantes->fecha_ingreso_club=$request->fecha_ingreso_club;
        $acampantes->telefono=$request->telefono;
        $acampantes->direccion=$request->direccion;
        $acampantes->Edad=$request->Edad;
        $acampantes->eps_afiliada=$request->eps_afiliada;
        $acampantes->alergico=$request->alergico;
        $acampantes->medicamento_alergias=$request->medicamento_alergias;
        $acampantes->enfermedades_cronicas=$request->enfermedades_cronicas;
        $acampantes->medicamento_enfermedades_cronicas=$request->medicamento_enfermedades_cronicas;
        $acampantes->en_caso_de_accidente_avisar_a=$request->en_caso_de_accidente_avisar_a;
        $acampantes->relacion_persona_de_contacto=$request->relacion_persona_de_contacto;
        $acampantes->telefono_persona_contacto=$request->telefono_persona_contacto;
        $acampantes->club_id=$request->club_id;


        $acampantes->save();
        return response()->json($acampantes, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $acampante = Acampantes::find($id);
        if (!$acampante) {
            return response()->json(['message' => 'Acampante no encontrado'], 404);
        }
        return response()->json($acampante, 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $club_id, $acampante_id)
    {
        $acampante = Acampantes::find($acampante_id);
        if (!$acampante) {
            return response()->json(['message' => 'Acampante no encontrado'], 404);
        }
        $acampante->update($request->all());
        return response()->json($acampante, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $acampantes = Acampantes::find($id);
        if($acampantes){
        $acampantes->delete();
        return response()->json($acampantes, 200);
    }else{
        return response()->json(['message' => 'acampante no encontrado no encontrado'], 404);
    }
    }

    public function indexByClub($club_id)
    {
        // Retrieve the club with the given ID
        $club = Clubes::find($club_id);
    
        // If the club was not found, return a 404 error
        if (!$club) {
            return response()->json(['message' => 'Club not found'], 404);
        }
    
        // Use the `acampantes` relationship to retrieve all acampantes associated with the club

      $acampantes = $club->acampantes;
    
        return response()->json($acampantes);
    }

    public function descargarExcel($club_id)
    {
        // Obtén el club con el id especificado
        $club = Clubes::find($club_id);
        if (!$club) {
            return response()->json(['message' => 'Club no encontrado'], 404);
        }

       
      
    
        // Obtén todos los acampantes (registros) asociados al club
        $acampantes = Acampantes::where('club_id', $club_id)->get();
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Agrega el título del club como primera fila
        $sheet->setCellValue('A1', 'Lista de Acampantes - ' . $club->nombre);
        $sheet->mergeCells('A1:T1'); // Fusiona las celdas para el título
        $sheet->getStyle('A1')->getFont()->setBold(true); // Establece el título en negrita
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Centra el título
    
        // Agrega una fila vacía después del título para separar
        $sheet->getRowDimension(2)->setRowHeight(10); // Establece la altura de la fila en 10 para crear espacio
        $sheet->getRowDimension(1)->setRowHeight(30); // Establece la altura de la fila en 30 para hacerla más grande
        $sheet->getRowDimension(2)->setRowHeight(15); // Establece la altura de la fila en 15 para crear espacio
    
        // Agrega los nombres de los campos como encabezados (fila 1)
        $headers = [
            'A3' => 'Tipo de Entrada',
            'B3' => 'Cargo',
            'C3' => 'Nombre Completo',
            'D3' => 'Correo',
            'E3' => 'Tipo de sangre',
            'F3' => 'Tipo documento identificacion',
            'G3' => 'Numero Identificacion',
            'H3' => 'Fecha De Nacimiento',
            'I3' => 'Fecha ingreso al Club',
            'J3' => 'Telefono',
            'K3' => 'Direccion',
            'L3' => 'Edad',
            'M3' => 'EPS Afiliada',
            'N3' => 'Alergico',
            'O3' => 'Medicamento Alergias',
            'P3' => 'Enfermedades Cronicas',
            'Q3' => 'Medicamento para las Enfermedades Cronicas',
            'R3' => 'En caso de accidente avisar a',
            'S3' => 'Relacion persona de contacto',
            'T3' => 'Telefono persona de contacto'
        ];
    
        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }
    
        for ($col = 'A'; $col <= 'T'; $col++) {
            $sheet->getColumnDimension($col)->setWidth(28.00);
        }
    
        $sheet->getRowDimension(3)->setRowHeight(25); // Establece la altura de la fila en 25 para hacerla más grande
    
        // Establece el estilo en negrita y centrado para la fila de encabezados
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $sheet->getStyle('A3:T3')->applyFromArray($styleArray);
    
        // Llena las celdas con los datos de los acampantes
        foreach ($acampantes as $index => $acampante) {
            $row = $index + 4; // Offset de 1 para comenzar desde la fila siguiente a los encabezados
            $sheet->setCellValue('A' . $row, $acampante->tipo_entrada);
            $sheet->setCellValue('B' . $row, $acampante->cargo);
            $sheet->setCellValue('C' . $row, $acampante->nombre_completo);
            $sheet->setCellValue('D' . $row, $acampante->email);
            $sheet->setCellValue('E' . $row, $acampante->tipo_sangre);
            $sheet->setCellValue('F' . $row, $acampante->tipo_documento_identificacion);
            $sheet->setCellValue('G' . $row, $acampante->numero_identificacion);
            $sheet->setCellValue('H' . $row, $acampante->fecha_nacimiento);
            $sheet->setCellValue('I' . $row, $acampante->fecha_ingreso_club);
            $sheet->setCellValue('J' . $row, $acampante->telefono);
            $sheet->setCellValue('K' . $row, $acampante->direccion);
            $sheet->setCellValue('L' . $row, $acampante->edad);
            $sheet->setCellValue('M' . $row, $acampante->eps_afiliada);
            $sheet->setCellValue('N' . $row, $acampante->alergico);
            $sheet->setCellValue('O' . $row, $acampante->medicamento_alergias);
            $sheet->setCellValue('P' . $row, $acampante->enfermedades_cronicas);
            $sheet->setCellValue('Q' . $row, $acampante->medicamento_enfermedades_cronicas);
            $sheet->setCellValue('R' . $row, $acampante->en_caso_de_accidente_avisar_a);
            $sheet->setCellValue('S' . $row, $acampante->relacion_persona_de_contacto);
            $sheet->setCellValue('T' . $row, $acampante->telefono_persona_contacto);
        }
    
        // Usa el nombre del club para el nombre del archivo y limpia caracteres no válidos
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $club->nombre) . '.xlsx';
        
    
        // Genera el archivo temporalmente en memoria
        $writer = new Xlsx($spreadsheet);
        $tempFilePath = storage_path('app/public/' . $filename); // Guardar en el directorio de almacenamiento público
    
        $writer->save($tempFilePath);
    
        // Devuelve el archivo para la descarga con el nombre correcto
        return response()->download($tempFilePath, $filename)->deleteFileAfterSend(true);
    }
    


    //DESCARGAR EN PDFS

    public function descargarPDF($club_id)
    {
        // Obtén el club con el id especificado
        $club = Clubes::find($club_id);
        if (!$club) {
            return response()->json(['message' => 'Club no encontrado'], 404);
        }
    
        // Obtén todos los acampantes (registros) asociados al club
        $acampantes = Acampantes::where('club_id', $club_id)->get();
    
        // Configura opciones de Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);
    
        // Construye el contenido HTML para el PDF
        $html = '<h1>Lista de Acampantes - ' . htmlspecialchars($club->nombre) . '</h1>';
    
        // Itera sobre los acampantes y agrega sus detalles al HTML
        foreach ($acampantes as $acampante) {
            $html .= '<p><strong>ID del Acampante:</strong> ' . $acampante->id . '</p>';
            $html .= '<p><strong>Nombre:</strong> ' . htmlspecialchars($acampante->nombre_completo) . '</p>';
            $html .= '<p><strong>Correo:</strong> ' . htmlspecialchars($acampante->email) . '</p>';
            $html .= '<p><strong>Edad:</strong> ' . $acampante->Edad . '</p>';
            $html .= '<p><strong>Tipo de Sangre:</strong> ' . htmlspecialchars($acampante->tipo_sangre) . '</p>';
            $html .= '<p><strong>Tipo Documento Identificación:</strong> ' . htmlspecialchars($acampante->tipo_documento_identificacion) . '</p>';
            $html .= '<p><strong>Número Identificación:</strong> ' . htmlspecialchars($acampante->numero_identificacion) . '</p>';
            $html .= '<p><strong>Fecha de Nacimiento:</strong> ' . $acampante->fecha_nacimiento . '</p>';
            $html .= '<p><strong>Fecha de Ingreso al Club:</strong> ' . $acampante->fecha_ingreso_club . '</p>';
            $html .= '<p><strong>Teléfono:</strong> ' . htmlspecialchars($acampante->telefono) . '</p>';
            $html .= '<p><strong>Dirección:</strong> ' . htmlspecialchars($acampante->direccion) . '</p>';
            $html .= '<p><strong>EPS Afiliada:</strong> ' . htmlspecialchars($acampante->eps_afiliada) . '</p>';
            $html .= '<p><strong>Alergico:</strong> ' . htmlspecialchars($acampante->alergico) . '</p>';
            $html .= '<p><strong>Medicamento Alergias:</strong> ' . htmlspecialchars($acampante->medicamento_alergias) . '</p>';
            $html .= '<p><strong>Enfermedades Crónicas:</strong> ' . htmlspecialchars($acampante->enfermedades_cronicas) . '</p>';
            $html .= '<p><strong>Medicamento para las Enfermedades Crónicas:</strong> ' . htmlspecialchars($acampante->medicamento_enfermedades_cronicas) . '</p>';
            $html .= '<p><strong>En caso de accidente avisar a:</strong> ' . htmlspecialchars($acampante->en_caso_de_accidente_avisar_a) . '</p>';
            $html .= '<p><strong>Relación persona de contacto:</strong> ' . htmlspecialchars($acampante->relacion_persona_de_contacto) . '</p>';
            $html .= '<p><strong>Teléfono persona de contacto:</strong> ' . htmlspecialchars($acampante->telefono_persona_contacto) . '</p>';
            $html .= '<hr>'; // Línea divisoria entre acampantes
        }
    
        // Carga el contenido HTML en Dompdf
        $dompdf->loadHtml($html);
    
        // Renderiza el PDF
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
    
        // Genera el nombre del archivo PDF
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $club->nombre) . '.pdf';
    
        // Devuelve el archivo PDF para la descarga
        return response()->streamDownload(function() use ($dompdf) {
            echo $dompdf->output();
        }, $filename);
    }

    public function getTotalAcampantes()
{
    $totalAcampantes = Acampantes::count();
    return response()->json(['total_acampantes' => $totalAcampantes]);
}

}
