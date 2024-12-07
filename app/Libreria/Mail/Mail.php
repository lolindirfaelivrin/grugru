<?php
namespace Libreria\Mail;
class Mail
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $socket;

    public function __construct($host, $port, $username, $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    public function sendMail($from, $to, $subject, $message)
    {
        $this->connect();
        $this->authenticate();

        $this->sendCommand("MAIL FROM:<$from>");
        $this->sendCommand("RCPT TO:<$to>");
        $this->sendCommand("DATA");

        $headers = "From: <$from>\r\n";
        $headers .= "To: <$to>\r\n";
        $headers .= "Subject: $subject\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $fullMessage = $headers . "\r\n" . $message . "\r\n.";

        $this->sendCommand($fullMessage);
        $this->sendCommand("QUIT");

        $this->disconnect();
    }

    private function connect()
    {
        $this->socket = fsockopen($this->host, $this->port, $errno, $errstr, 10);
        if (!$this->socket) {
            throw new \Exception("Could not connect to SMTP host: $errstr ($errno)");
        }
        $this->getResponse();
    }

    private function authenticate()
    {
        $this->sendCommand("EHLO " . $this->host);
        $this->sendCommand("AUTH LOGIN");
        $this->sendCommand(base64_encode($this->username));
        $this->sendCommand(base64_encode($this->password));
    }

    private function sendCommand($command)
    {
        fputs($this->socket, data: $command . "\r\n");
        return $this->getResponse();
    }

    private function getResponse()
    {
        $response = '';
        while ($str = fgets($this->socket, 512)) {
            $response .= $str;
            if (strpos($str, ' ') === 3)
                break;
        }
        return $response;
    }

    private function disconnect()
    {
        fclose($this->socket);
    }
}

// Usage example
try {
    $mailer = new Mail('smtp.example.com', 25, 'username', 'password');
    $mailer->sendMail('sender@example.com', 'recipient@example.com', 'Test Email', 'Hello, this is a test email!');
    echo "Email sent successfully!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}