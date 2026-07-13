<?php

namespace App\Repositories\Archives;

use App\Models\Archives\ArchivesProssesed\ArchivesProssesed;
use App\Repositories\IndexRepositorie;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

            $tempPath = $file->store('temp');

            $calculatedHash = hash_file('sha256', Storage::path($tempPath));

            if ($calculatedHash != $hash_file)
            {
                Storage::delete($tempPath);

                return response()->json([
                    'message' => "Error con el archivo",
                    'hash_file' =>$data['hash_file'],
                    'hash_calculated' =>$calculatedHash,
                ], Response::HTTP_CONFLICT);
            }

            Storage::delete($tempPath);
            $path = $file->store('private');
            $file_name = $file->getClientOriginalName();
            $file_size = $file->getSize();

            $message = "";

            return response()->json([
                    'message' => $message,
                    'path' => $path,
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'hash_file' =>$data['hash_file'],
                    'hash_calculated' =>$calculatedHash,
            ], Response::HTTP_CREATED);

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
    }

}