<?php


/**
 * Cargo class
 */
class Apitokens
{

    use Model;

    protected $table = 'api_tokens';

    protected $allowedColumns = [
        'id',
        'api_key',
        'provider',
        'date'
    ];

    public function getToken($provider)
    {
        $query = "select * from $this->table WHERE provider = '$provider' LIMIT 1;";
        return $this->query($query)[0]->api_key;
    }

}