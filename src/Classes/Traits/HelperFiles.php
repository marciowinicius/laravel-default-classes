<?php

namespace MarcioWinicius\LaravelDefaultClasses\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

trait HelperFiles
{
    private $imageExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'bmp', 'BMP', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief', 'jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd', 'HEIC', 'heic'];
    private $publicPathResizedImages = 'imgs/resized/';

    private function fetchRequestFiles(array $request, $arrayPosition)
    {
        $requestCapture = Request::capture();
        if ($requestCapture->hasFile($arrayPosition)) {
            $request[$arrayPosition] = $requestCapture->file($arrayPosition);
        } elseif (array_key_exists($arrayPosition, $request)) {
            $request[$arrayPosition] = null;
        }
        return $request;
    }

    private function saveFileInFilesystem(array $request, $arrayPosition)
    {
        if (array_key_exists($arrayPosition, $request) and !is_null($request[$arrayPosition])) {
            $arquivo = $request[$arrayPosition];
            $tipoArquivo = $arquivo->getClientOriginalExtension();
            $filename = Str::random() . '-' . Carbon::now()->timestamp;
            Storage::disk(env('FILESYSTEM_DRIVER'))->putFileAs(env('APP_NAME'), $arquivo, $filename . "_original." . $tipoArquivo, "public");
            $request[$arrayPosition] = env('APP_NAME') . $filename . (in_array($tipoArquivo, $this->imageExtensions) ? '':'_original') . "." . $tipoArquivo;

            $request['hash'] = $filename;
            $request['file_size'] = $arquivo->getSize();
            $request['file_type'] = $tipoArquivo;

            if (in_array($tipoArquivo, $this->imageExtensions)) {
                if (!file_exists(public_path($this->publicPathResizedImages))) {
                    mkdir(public_path($this->publicPathResizedImages), 777, true);
                }
                $imagemPeq = Image::make($arquivo->getRealPath());
                $imagemPeq->resize(250, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imagemPeq->orientate();
                $imagemPeq->save($this->publicPathResizedImages . $filename . "." . $tipoArquivo, 50);
                $file_path = public_path($this->publicPathResizedImages . $filename . "." . $tipoArquivo);
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $uploadedImagemPeq = new UploadedFile($file_path, $filename, $finfo->file($file_path), filesize($file_path), 0, false);
                Storage::disk(env('FILESYSTEM_DRIVER'))->putFileAs(env('APP_NAME'), $uploadedImagemPeq, $filename . "_peq." . $tipoArquivo, "public");
                Storage::disk(env('FILESYSTEM_DRIVER'))->putFileAs(env('APP_NAME'), $uploadedImagemPeq, $filename . "." . $tipoArquivo, "public");
                File::delete(public_path($this->publicPathResizedImages . $filename . "." . $tipoArquivo));

                $imagemMed = Image::make($arquivo->getRealPath());
                $imagemMed->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imagemMed->orientate();
                $imagemMed->save($this->publicPathResizedImages . $filename . "_med." . $tipoArquivo, 80);
                $file_path = public_path($this->publicPathResizedImages . $filename . "_med." . $tipoArquivo);
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $uploadedImagemMed = new UploadedFile($file_path, $filename, $finfo->file($file_path), filesize($file_path), 0, false);
                Storage::disk(env('FILESYSTEM_DRIVER'))->putFileAs(env('APP_NAME'), $uploadedImagemMed, $filename . "_med." . $tipoArquivo, "public");
                File::delete(public_path($this->publicPathResizedImages . $filename . "_med." . $tipoArquivo));
            }
        }
        if (array_key_exists($arrayPosition . '_deletar', $request)){
            Storage::disk(env('FILESYSTEM_DRIVER'))->delete($request[$arrayPosition . '_deletar']);
        }
        return $request;
    }
}
