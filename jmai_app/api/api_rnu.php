<?php

class ApiRNU
{

    public $url = 'http://localhost:4000/api';

    public $curl;
    public $response;
    public $responseLength;
    public $responseCode;
    public $responseHeaders;

    /* ========================||========================||======================== */
    // CONSTRUCTOR
    /* ========================||========================||======================== */

    // Abrir a Conexão
    public function InitCurl()
    {
        $this->CreateHeaders();
        $this->curl = curl_init();
    }

    // Criar Headers
    public function CreateHeaders()
    {
        $this->responseHeaders = array(
            'Content-Type: application/json'
        );
    }

    // Fechar a Conexão
    public function CloseCurl()
    {
        curl_close($this->curl);
    }

    /* ========================||========================||======================== */
    // METHODS - FETCH
    /* ========================||========================||======================== */

    // Fetch
    public function fetch($path, $data = null, $id = null)
    {

        $this->InitCurl();
        $data = $data !== null ? '/' . http_build_query($data) : '';
        $path = $id !== null ? $path . '/' . $id : $path;

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $this->url . '/' . $path . $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $this->responseHeaders,
        ));

        $this->response = json_decode(curl_exec($this->curl), true);
        $this->responseCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $this->responseLength = $this->responseCode == 200 ? count($this->response) : 0;

        $this->CloseCurl();

        return array(
            'status' => $this->responseCode == 200 ? true : false,
            'response' => $this->response,
            'responseCode' => $this->responseCode,
            'responseLength' => $this->responseLength,
        );
    }

    /* ========================||========================||======================== */
    // METHODS - POST
    /* ========================||========================||======================== */

    // Post
    public function post($path, $data, $id = null)
    {

        $this->InitCurl();

        if ($id !== null) {
            $path = $path . '/' . $id;
        }

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $this->url . '/' . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $this->responseHeaders,
        ));

        $this->response = json_decode(curl_exec($this->curl), true);
        $this->responseCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $this->responseLength = $this->responseCode == 201 ? count($this->response) : 0;

        $this->CloseCurl();

        return array(
            'status' => $this->responseCode == 201 ? true : false,
            'response' => $this->response,
            'responseCode' => $this->responseCode,
            'responseLength' => $this->responseLength,
        );
    }
}
