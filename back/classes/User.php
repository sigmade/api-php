<?php


namespace classes;

use classes\helpers\DB;
use classes\helpers\TextSecurity;
use mysql_xdevapi\Exception;
use PHPMailer\PHPMailer\PHPMailer;


class User
{
    public function __construct()
    {
        $this->DB = DB::init();
    }

    public function login(array $array)
    {
        $resDb = $this->check_email_and_pass($array);
        $email = strtolower($array["email"]);

        // если пользователь есть в базе
        if($resDb)
        {
            return $resDb;
        }

        // если нет пользователя создадим его
        $token = $this->new_token();
        $arr = [
            "email" => $email,
            "pass" => password_hash($array["pass"], PASSWORD_DEFAULT),
            "date" => time(),
            "token" => $token
        ];

        $resDb = $this->DB->insert("users", $arr);

        // отправим письмо
        $mail = new PHPMailer();
        $mail->isMail();
        $mail->CharSet = "utf-8";
        $mail->setFrom("admin@test.com", "from API");
        $mail->isHTML(true);
        $mail->Subject = "Подтверждение email";
        $mail->addAddress($email);
        $mail->Body = "
            <h1>Welcome to API</h1>
            <p>Для завершения регистрации подтвердите свой email по ссылке: 
              <a href='".HOST."api/?method_name=confirm_email&token=".$token."'> 
              ".HOST."api/?method_name=confirm_email&token=".$token."
              </a>
            </p>
        ";
        $mail->send();

        return false;

    }

    public function confirm(string $token)
{
    if(!$token = TextSecurity::shield_hard($token))
    {
        throw new \Exception("Не корректный токен");
    }

    $new_token = $this->new_token();
    $this->DB->where("token", $token);
    $this->DB->update("users", [
        "token" => $new_token,
        "verified" => 1
    ]);

    $this->DB->where("token", $new_token);
    return $this->DB->getOne("users");
}

    public function isAuth($token)
    {
        if(!$token = TextSecurity::shield_hard($token)){ return false; }

        $this->DB->where("token", $token);
        return $this->DB->getOne("users");
    }

    public function new_token()
    {
        return hash("md5", time().rand());
    }

    public function check_email_and_pass($array)
    {
        if(!$email = filter_var($array["email"], FILTER_VALIDATE_EMAIL))
        {
            throw new \Exception("Не корректный email", 1);
        }

        $email = strtolower($email);

        $this->DB->where("email", $email);
        $resDb = $this->DB->getOne("users");

        if (!$resDb){ return false; }

        if(!$array["pass"] || !password_verify($array["pass"], $resDb["pass"])){
            throw new \Exception("Не верный пароль", 2);
        }

        if(!$resDb['verified']){
            throw new \Exception("Необходимо подтвердить email");
        }

        return $resDb;

    }
}