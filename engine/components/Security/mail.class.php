<?php
class Mail
{
    public $tos     = ''; # Кому отправляется письмо
    public $subject = ''; # Тема письма
    public $headers = ''; # Заголовки должны быть отправлены
    public $message = ''; # Сообщение письма которое будет генерироватся при его отправке в зависимости от нужл

    public function headers()
    {
        $this->headers .= 'From: admin@project.ru' . "\r\n" .
        'Reply-To: admin@project.ru' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        return $this->headers;
    }

    public function send()
    {
        mail($this->tos, $this->subject, $this->message, $this->headers());
    }
}
