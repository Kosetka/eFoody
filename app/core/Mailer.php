<?php

class Mailer {
    private $to;
    private $subject;
    private $message;
    private $headers;
    private $lastError;

    public function __construct($to, $subject, $message, $headers = []) {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;

        // Dodawanie domyślnych nagłówków, jeśli nie zostały podane
        if (empty($headers)) {
            $headers[] = 'From: noreply@radluks.pl';
            $headers[] = 'Reply-To: noreply@radluks.pl';
            $headers[] = 'X-Mailer: PHP/' . phpversion();
            $headers[] = 'Content-type: text/html; charset=utf-8';
        }
        $this->headers = implode("\r\n", $headers);
    }

    public function send() {
        if (mail($this->to, $this->subject, $this->message, $this->headers)) {
            return true;
        } else {
            $this->lastError = error_get_last();
            return false;
        }
    }
    public function getLastError() {
        return $this->lastError;
    }
    public static function loadTemplate($templatePath, $variables = [])
    {
        if (!file_exists($templatePath)) {
            return "Błąd: Szablon nie istnieje!";
        }

        ob_start();
        extract($variables);
        include $templatePath;
        return ob_get_clean();
    }
}