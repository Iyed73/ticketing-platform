<?php
require_once "src\Models\UniqueTokenRepo.php";
//a token contains two parts selector and validator the selector is used to find the user token in the database then a validator is comaared with the hashed validator to verify the token
//the addition of the validator is a security measure to prevent timing attacks
//the expiry date of the token is also verified
class rememberMeService {
    private $uniqueTokenTable;

    public function __construct() {
        $this->uniqueTokenTable = new UniqueTokenRepo();
    }

    function generateToken(){
        $selector = bin2hex(random_bytes(16)); // 32 characters
        $validator = bin2hex(random_bytes(32)); // 64 characters
        $token = $selector . ":" . $validator;
        return $token;
    }

    function parseToken($token){
        return explode(":", $token);
    }

    public function rememberMe($userId) {
        //delete all previous token
        $this->forgetMe($userId);
        //generate new token
        $token = $this->generateToken();
        $data = [
            'selector' => $this->parseToken($token)[0],
            'hashed_validator' => password_hash($this->parseToken($token)[1], PASSWORD_DEFAULT),
            'user_id' => $userId,
            'expiry' => date('Y-m-d H:i:s', time() + 60*60*24*30)
        ];
        $this->uniqueTokenTable->insert($data);
        setcookie('remember_me',$token,time() + 60*60*24*30, '/');
    }

    public function forgetMe($userId) {
        $this->uniqueTokenTable->deleteByUserId($userId);
        setcookie('remember_me','',time() - 3600,'/');
    }

    public function validateToken($token) {
        $parsedToken = $this->parseToken($token);
        //check if token is valid
        if(count($parsedToken) != 2) {
            return false;
        }

        $userToken = $this->uniqueTokenTable->findTokenBySelector($parsedToken[0]);
        if ($userToken) {
            if (password_verify($parsedToken[1], $userToken->hashed_validator)) {
                return $userToken;
            }
        }
        return false;
    }

    public function loginWithToken($token) {
        $userToken = $this->validateToken($token);
        if ($userToken) {
            $user = $this->uniqueTokenTable->findUserBySelector($userToken->selector);
            if ($user) {
                $_SESSION["user_id"] = $user->id;
                $_SESSION["email"] = $user->email;
                $_SESSION["role"] = $user->role;
                return true;
            }
        }
        return false;
    }
}



