<?php

namespace Kzu\Http;

Trait Request {
    static public $parameters = [];

    static public function getRequest(): array {
        return [
            'url' => Request::getUrl(),
            'uri' => Request::getUri(),
            'headers' => Request::getHeaders(),
            'parameters' => Request::getParameters(),
        ];
    }

    static public function getUrl(): string {
        return Request::getSheme() . "://" . Request::getHost() . Request::getUri();
    }

    static public function getSheme(): string {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    }

    static public function getHost(): string {
        return $_SERVER['HTTP_HOST'];
    }

    static public function getUri(): string {
        return $_SERVER['REQUEST_URI'] ?? "/";
    }

    static public function getIp(): ?string {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])):
            return $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        else:
            return $_SERVER['REMOTE_ADDR'];
        endif;
        return null;
    }

    static public function getHeaders(): array {
        return getallheaders() ?? [];
    }

    static public function getParameters(): array {
        return array_merge(Request::$parameters, $_REQUEST, $_GET, $_POST) ?? [];
    }

    static public function getParameter(string $key) {
        return Request::getParameters()[$key] ?? null;
    }

    static public function setParameter(string $key, $value) {
        Request::$parameters[$key] = $value;
    }
}