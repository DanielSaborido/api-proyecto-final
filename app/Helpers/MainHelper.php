<?php

use App\Helpers\Mail as MailHelper;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

if (!function_exists('array_to_object')) {

    /**
     * Convert Array into Object in deep
     *
     * @param array $array
     * @return
     */
    function array_to_object($array)
    {
        return json_decode(json_encode($array));
    }
}

if (!function_exists('empty_fallback')) {

    /**
     * Empty data or null data fallback to string -
     *
     * @return string
     */
    function empty_fallback ($data)
    {
        return ($data) ? $data : "-";
    }
}

if (!function_exists('create_button')) {

    function create_button ($action, $model)
    {
        $action = str_replace($model, "", $action);

        return [
            'submit_text' => ($action == "update") ? "Update" : "Submit",
            'submit_response' => ($action == "update") ? "Updated." : "Submited.",
            'submit_response_notyf' => ($action == "update") ? "Data ".$model." updated successfully" : "Data ".$model." added successfully"
        ];
    }
}

if (!function_exists('standard_date')) {

    function standard_date ($date)
    {
        if (!is_null($date)) {
            $separator = "";

            if (strpos($date, '-')) {
                $separator = '-';
            }

            if (strpos($date, '/')) {
                $separator = '/';
            }

            if ($separator === "") {
               return null;
            }

            $explodedDate = explode($separator, $date);
            $day = $explodedDate[0];
            $month = $explodedDate[1];

            if ($separator == '/') {
                $year = isset($explodedDate[2]) ? $explodedDate[2] : date('Y');

                if (strlen($year) == 2) {
                    $year = "20{$year}";
                }

                if ($day < 10) {
                    if (strpos($day, '0') === false) {
                        $day = "0{$day}";
                    }
                }

                if ($month < 10) {
                    if (strpos($month, '0') === false) {
                        $month = "0{$month}";
                    }
                }
            
                return "{$year}-{$month}-{$day}";
            }
        }
         
        return null;
    }
}

if (! function_exists('formato_decimal')) {
    
    function formato_decimal($numero, $decimales = 2, $multiplicador = null) {
        if ($numero <> 0) {
            if (is_numeric($numero)) {
                $numero = $multiplicador
                    ? ($numero * $multiplicador)
                    : $numero;

                $numero = number_format($numero, $decimales, ',', '.');
                $arrayNumero = explode(",", $numero);
                if ($arrayNumero[1] == "00") {
                    return $arrayNumero[0];
                }
                return $numero;
            }
            
            return $numero ?: '';
        }

        return $numero ?: '-';
    }
}

if (! function_exists('formato_fecha')) {
    
    function formato_fecha($fecha, $formato = 'd/m/y') {
        if ($fecha == null) {
            return '';
        }

        return \Carbon\Carbon::parse($fecha)->format($formato);
    }
}

if (! function_exists('division')) {
    
    function division($dividendo, $divisor) {
        if ($divisor == 0) {
            return 0;
        }

        return $dividendo / $divisor;
    }
}

if (! function_exists('email_config')) {
    
    function email_config($parametro)
    {
        return MailHelper::getMail($parametro);
    }
}

if (! function_exists('saveFileFromBase64')) {
    /**
     * 
     *
     * @param  string  $documento
     * Aquí va el documento en base64 que llega desde la request.
     * 
     * @param  string  $nombre
     * Nombre del documento, por ejemplo, bajas_empleados_Paco_Mel_02/11/2022 (la extension la obtiene automáticamente).
     * 
     * @param  string  $storageDisk
     * Javi no quiere que ponga nada.
     * 
     * @return bool    $file
     */

    function saveFileFromBase64($documento, $nombre, $storageDisk)
    {
        $ext = explode('/', mime_content_type($documento))[1];

        if ($ext == 'vnd.openxmlformats-officedocument.wordprocessingml.document') {
            $ext = 'docx';
        }

        if ($ext == 'rtf') {
            $ext = 'doc';
        }

        if ($ext == 'png') {
            $ext = 'png';
        }
        
        if ($ext == 'pdf') {
            $ext = 'pdf';
        }
        $exp = explode(',', $documento);
        $documento = $exp[1];
        
        $nombreArchivo = "{$nombre}.{$ext}";

        // $file = Storage::disk('bajas_laborales_empleados')->put($nombreArchivo, base64_decode($documento));
        Storage::disk($storageDisk)->put($nombreArchivo, base64_decode($documento));
        
        return $nombreArchivo;
    }
}

if (! function_exists('getFileToBase64')) {
    function getFileToBase64($filestring)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_buffer($finfo, $filestring);
        $base64_file = base64_encode($filestring);
        return "data:$mime_type;base64,$base64_file";
    }
}

if (! function_exists('base64ToFile')) {
    /**
     *
     * @param  string  $base64string
     * Fichero en base 64.
     *
     * @return UploadedFile $file
     */

    function base64ToFile($base64string)
    {
        // Get file data base64 string
        $fileData = base64_decode(Arr::last(explode(',', $base64string)));

        // Create temp file and get its absolute path
        $tempFile = tmpfile();
        $tempFilePath = stream_get_meta_data($tempFile)['uri'];

        // Save file data in file
        file_put_contents($tempFilePath, $fileData);

        $tempFileObject = new File($tempFilePath);
        $file = new UploadedFile(
            $tempFileObject->getPathname(),
            $tempFileObject->getFilename(),
            $tempFileObject->getMimeType(),
            0,
            true
        );

        // Close this file after response is sent.
        // Closing the file will cause to remove it from temp director!
        app()->terminating(function () use ($tempFile) {
            fclose($tempFile);
        });

        // return UploadedFile object
        return $file;
    }
}