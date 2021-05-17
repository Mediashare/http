<?php

namespace Kzu\Http;

Trait Response {
    static public function return(string $content, ?array $headers = [], ?int $status_code = 200) {
        Response::setHeader($headers, $status_code);
        Response::setStatusCode($status_code);
        echo $content;
    }

    static public function file(string $filepath, ?array $headers = [], ?int $status_code = 200) {
        if (!file_exists($filepath)):
            return Response::redirectToRoute('error_404');
        endif;
        Response::setHeader(
            array_merge($headers, [
                'Content-Type' => mime_content_type($filepath),
            ]), $status_code);
        Response::setStatusCode($status_code);
        echo file_get_contents($filepath);
    }

    static public function json(array $array, ?array $headers = [], ?int $status_code = 200) {
        Response::setHeader(array_merge(['Content-Type' => 'text/json'], $headers), $status_code);
        Response::setStatusCode($status_code);
        echo json_encode($array);
    }

    static public function redirectTo(string $path, ?int $status_code = 302) {
        Response::setStatusCode($status_code);
        header('Location: '. $path, true, $status_code);
    }

    static public function setHeader(?array $headers = [], ?int $status_code = 200) {
        Response::setStatusCode($status_code);
        header('Content-Type: text/html; charset=utf-8', true, $status_code);
        foreach ($headers as $header => $value):
            header($header.": ".$value, true);
        endforeach;
    }

    static public function setStatusCode(int $status_code) {
        return \http_response_code($status_code);
    }
}