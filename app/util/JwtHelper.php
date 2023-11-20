<?php
declare(strict_types=1);

namespace App\Util;

use Firebase\JWT\JWT;

class JwtHelper{

    private $jwtSettings;
    private $subjectType;//U-G, U-D, R-G, R-D

    public function __construct(array $jwtSettings){
        //$this->subjectType = $userType;
        $this->jwtSettings = $jwtSettings;
    }

    public function generateRegistrantIdToken($data){
        $this->subjectType = "R-G";
        //
        return $this->generateIdToken($data);
    }

    private function generateIdToken($data)
    {
        //subtype = U-G, U-D, R-G, R-D
        $data['subtype'] = $this->subjectType;

        // Generate a JWT token with the provided data
        $issuedAt = time();
        $expirationTime = $issuedAt + $this->jwtSettings['valid_for']; // 1 hour

        $payload = [

            'name' =>$data['name'],
            //'picture' =>$data['picture'],
            'iss' =>$data['iss'],
            'aud' =>$data['aud'],
            'sub' =>$data['sub'],
            'subtype' =>$data['subtype'],
            'email' =>$data['email'],
            'sign_in_provider' =>$data['sign_in_provider'],
            //
            'iat' => $issuedAt,       // Issued at timestamp
            'exp' => $expirationTime, // Expiration time
            //'data' => $data,

        ];
       
        //##########
        return JWT::encode($payload, $this->jwtSettings['secret_key'], $this->jwtSettings['algorithm']);
    }
}