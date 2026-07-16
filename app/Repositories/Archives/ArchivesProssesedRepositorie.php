<?php

namespace App\Repositories\Archives;

use App\Models\Archives\ArchivesProssesed\ArchivesProssesed;
use App\Models\Archives\Metadata\Metadata;
use App\Repositories\IndexRepositorie;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SplFileObject;

/**
 * class ArchivesProssesedRepositorie
 * 
 * @author Cesar Sergio <cesar.consuelo.cervantes@gmail.com>
 */
class ArchivesProssesedRepositorie extends IndexRepositorie
{
    public function __construct(ArchivesProssesed $archivesProssesed) {
        $this->model = $archivesProssesed;
    }

    /**
     * Store the uploaded file in a temporary folder.
     * and calculate the SHA-512 hash of the stored file.
     *
     * @param array $data
     * @return JsonResponse
     */
    public function createArchiveProssesed(array $data): JsonResponse
    {
        try {
            $file = $data['file'];
            $hash_file = strtolower($data['hash_file']);

            config(['filesystems.disks.app_root' => [
                'driver' => 'local',
                'root' => storage_path('app'),
            ]]);

            $tempPath = $file->store('temp', 'app_root');

            $calculatedHash = hash_file('sha256', Storage::disk('app_root')->path($tempPath));

            if ($calculatedHash != $hash_file)
            {
                Storage::disk('app_root')->delete($tempPath);

                return response()->json([
                    'message' => "Error con el archivo",
                    'hash_file' =>$data['hash_file'],
                    'hash_calculated' =>$calculatedHash,
                ], Response::HTTP_CONFLICT);
            }

            Storage::disk('app_root')->delete($tempPath);

            $path = $file->store('', 'local');
            $file_name = $file->getClientOriginalName();
            $file_size = $file->getSize();

            // $user_id = Auth::getUser()->id;
            $user_id = 1;

            $archive = new ArchivesProssesed();

            $archive->user_id  = $user_id;
            $archive->archive_name  = $file_name;
            $archive->archive_hash  = $calculatedHash;
            $archive->archive_path  = $path;
            $archive->archive_size_bytes  = $file_size;

            $archive->save();

        } catch (Exception $e) {
            $message = $e->getMessage();

            Log::error('Error creating Archive Prossesed', [
                'message' => $message,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                    'message' => $message
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $message = $this->prosesingData($path, $archive->id, $user_id);

        return response()->json([
                'message' => $message,
                'path' => $path,
                'file_name' => $file_name,
                'file_size' => $file_size,
                'hash_file' =>$data['hash_file'],
                'hash_calculated' =>$calculatedHash,
        ], Response::HTTP_CREATED);
    }

    private function prosesingData(String $path, String $file_id, String $user_id): String
    {
        $file = new SplFileObject(Storage::path($path));
        $file->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY
        ); 

        $file->setCsvControl('~');

        $message = "Se omitieron los siguientes datos:";
        $are_omit = false;
        foreach($file as $index => $row){

            if (!is_array($row) || $index == 0) {
                continue;
            }
            
            $omit_message = $this->registerMetadataRow($row, $file_id, $user_id);

            if ($omit_message != "")
            {
                $message .= "\n".$index.": ".$omit_message;
                $are_omit = true;
            }
        }
        return $are_omit? $message: "todos los datos se agregaron correctamente";
    }

    private function registerMetadataRow(array $row, String $file_id, String $user_id): String
    {
        try {

            $message = "";

            $metadata = Metadata::where('uuid', $row[0])->first();
            $fecha_certificacion_sat_current = Carbon::parse($row[7]);

            if ($metadata)
            {
                $fecha_certificacion_sat_after = Carbon::parse($metadata->fecha_certificacion_sat);
                if (!$fecha_certificacion_sat_current->gt($fecha_certificacion_sat_after))
                {
                    $message = "[";
                    foreach ($row as $atribute){
                        $message .= "{$atribute}, ";
                    }
                    $message .= " Devido a registro antiguo]";
                    return $message;
                }

            } else {
                $metadata = new Metadata();

                $metadata->user_id = $user_id;
                $metadata->archive_prossesed_id = $file_id;
                $metadata->uuid = $row[0];
            }

            $monto = intval($row[8]);
            $subtotal = $monto / 1.16;
            $iva = $subtotal*0.16;

            $fecha_emision = Carbon::parse($row[6]);

            $metadata->rfc_emisor = $row[1];
            $metadata->nombre_emisor = $row[2];
            $metadata->rfc_receptor = $row[3];
            $metadata->nombre_receptor = $row[4];
            $metadata->pac_certifico = $row[5];
            $metadata->fecha_emision = $fecha_emision;
            $metadata->fecha_certificacion_sat = $fecha_certificacion_sat_current;
            $metadata->monto = $monto;
            $metadata->iva = $iva;
            $metadata->sub_total = $subtotal;
            $metadata->efecto_comprobante = $row[9];
            $metadata->estatus = intval($row[10]);
            $metadata->fecha_cancelacion = $row[11];
            $metadata->state = "created";

            $metadata->save();

            return $message;
        } catch (Exception $e) {
            
            Log::error('Error creating Metadata', [
                'message' => $$e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $message = "[";

            foreach ($row as $atribute){
                $message .= "{$atribute}, ";
            }

            $message .= " Devido a error]";

            return  $message;
        }
    }

}