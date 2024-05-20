<?php

namespace App\Helpers;

class Mail
{
    /**
     * Recupera los emails de config
     * 
     * @param String $parametro
     *
     * @return void
     */
    public static function getMail(String $parametro)
    {
        if (config('app.debug')){
            return config('app.debug_mail');
        }

        return config("mail.{$parametro}");
    }
    
    /**
     * Corrige caracteres erroneos en los emails
     *
     * @return void
     */
    public static function sanitizeEmails($emails, $invalid)
    {
        foreach ($emails as $key => &$email) {
            // Remove all illegal characters from email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            
            if ($email === '') {
                unset($emails[$key]);
                continue;
            }
        
            // Validate e-mail
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                if (!in_array($email, $invalid)) {
                    unset($emails[$key]);
                    $invalid[] = "$email no es una direccion de email valida";
                }
            }
        }

        return array($invalid, $emails);
    }
}