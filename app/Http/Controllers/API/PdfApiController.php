<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PDFFile;
use App\Models\Clubes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\Acampantes;


class PdfApiController extends Controller
{       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $clubId = $request->query('clubId');

            if ($clubId) {
                // Asegúrate de que la columna 'club_id' existe y es correcta
                $pdfs = PDFFile::where('club_id', $clubId)->get();
            } else {
                $pdfs = PDFFile::all();
            }

            return response()->json(['data' => $pdfs], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error al obtener los PDFs: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
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
        $pdfFile = PDFFile::findOrFail($id);
        return response()->json($pdfFile);
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
        
        $file = PDFFile::findOrFail($id);
        // Eliminar el prefijo 'public/' de la ruta almacenada
        $path = str_replace('public/', '', $file->path);
    
        if (Storage::disk('public')->exists($path)) {
            if (Storage::disk('public')->delete($path)) {
                $file->delete();
                return response()->json(['message' => 'File deleted successfully.']);
            } else {
                return response()->json(['error' => 'Failed to delete the file.'], 500);
            }
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }

    }

    public function upload(Request $request, $clubId)
{
    \Log::info('Received upload request.');

    $validated = $request->validate([
        'file' => 'required|file|mimes:pdf|max:51200',
        'club_id' => 'required|exists:clubes,id',
    ]);

    if (!$request->hasFile('file')) {
        \Log::error('No file was uploaded.');
        return response()->json(['error' => 'No file was uploaded'], 400);
    }

    $club = Clubes::find($clubId);
    if (!$club) {
        return response()->json(['error' => 'Club not found'], 404);
    }

    $acampantesCount = Acampantes::where('club_id', $clubId)->count();
    if ($acampantesCount < 10) {
        return response()->json(['error' => 'El club no tiene suficientes acampantes. Debe tener al menos 10 acampantes.'], 400);
    }

    $file = $request->file('file');
    if (!$file->isValid()) {
        \Log::error('File is not valid.');
        return response()->json(['error' => 'File is not valid'], 400);
    }

    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('public/pdfs', $filename);

    if (!$path) {
        \Log::error('Failed to store the file.');
        return response()->json(['error' => 'Failed to store the file'], 500);
    }

    \Log::info('File stored at: ' . $path);

    try {
        $pdfFile = PDFFile::create([
            'name' => $filename,
            'path' => $path,
            'club_id' => $clubId,
        ]);
    } catch (\Exception $e) {
        \Log::error('Failed to save file info in database: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to save file info in database'], 500);
    }

    return response()->json([
        'message' => 'Archivo cargado correctamente',
        'file' => $pdfFile,
    ]);
}
    


   
       
public function download($id)
{
    $pdfFile = PDFFile::findOrFail($id);
    // Remueve 'public/' del path porque storage_path('app/public') ya está apuntando a 'storage/app/public'
    $correctPath = str_replace('public/', '', $pdfFile->path);
    $pathToFile = storage_path('app/public/' . $correctPath);

    if (!file_exists($pathToFile)) {
        return response()->json(['error' => 'File not found.', 'path' => $pathToFile], 404);
    }

    return response()->download($pathToFile, $pdfFile->name);
}

}
