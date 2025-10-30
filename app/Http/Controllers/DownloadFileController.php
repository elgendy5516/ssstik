<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadFileController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->filled('url') || empty($request->get('url')))
            return redirect()->route('home');

        return $this->streamDownloadResponse($request);
    }

    function streamDownloadResponse(Request $request)
    {
        $url = $request->get('url');
        $extension = $request->get('extension', 'mp4');
        $url = base64_decode($url);

        $filename = config("app.name") . '-' . time() . '.' . $extension;

        // start a buffer before sending headers
        // some php env may not buffer by default
        if (!ob_get_level()) ob_start();

        return response()->streamDownload(
            fn() => $this->streamFileContent($url),
            $filename,
            array_filter([
                'Content-Type' => 'application/octet-stream',
                'Content-Length' => $request->get('size'),
            ]));
    }

    function streamFileContent(string $url)
    {
        $ch = curl_init();
        $headers = array(
            'Range: bytes=0-',
        );
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FOLLOWLOCATION => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_USERAGENT => 'okhttp',
            CURLOPT_ENCODING => "utf-8",
            CURLOPT_AUTOREFERER => true,
            CURLOPT_REFERER => 'https://www.tiktok.com/',
            CURLOPT_CONNECTTIMEOUT => 600,
            CURLOPT_TIMEOUT => 600,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
        );
        curl_setopt_array($ch, $options);
        if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }

        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $data) {
            echo $data;
            ob_flush();
            flush();
            return strlen($data);
        });

        curl_exec($ch);
        curl_close($ch);
    }
}
