<?php
namespace Kinbalam\RestAPI\Controller\Component;

use Cake\Core\Configure;
use Cake\Controller\Component;
use Firebase\JWT\JWT;

class SecurityComponent extends Component 
{
    // Generates a jwt for a given user
    public function getJWT($user) {
        return JWT::encode([
            "sub" => $user["id"], 
            "name" => $user["description"]
        ], Configure::read('RestAPI.auth.jwt.secretKey'));
    }
}