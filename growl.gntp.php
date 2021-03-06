<?php

/*
Title:      Growl GNTP
URL:        http://github.com/jamiebicknell/Growl-GNTP
Author:     Jamie Bicknell
Twitter:    @jamiebicknell
*/

class Growl
{
    private $port = 23053;
    private $time = 5;
    
    public function __construct($host, $pass)
    {
        $this->host = $host;
        $this->pass = $pass;
        $this->salt = md5(uniqid());
        $this->application = '';
        $this->notification = '';
    }
    
    public function createHash()
    {
        $pass_hex = bin2hex($this->pass);
        $salt_hex = bin2hex($this->salt);
        $pass_bytes = pack('H*', $pass_hex);
        $salt_bytes = pack('H*', $salt_hex);
        return strtoupper('md5:' . md5(md5($pass_bytes.$salt_bytes, true)) . '.' . $salt_hex);
    }
    
    public function setApplication($application, $notification)
    {
        $this->application = $application;
        $this->notification = $notification;
    }
    
    public function registerApplication($icon = null)
    {
        $data  = 'GNTP/1.0 REGISTER NONE ' . $this->createHash() . "\r\n";
        $data .= 'Application-Name: ' . $this->application . "\r\n";
        if ($icon != null) {
            $data .= 'Application-Icon: ' . $icon . "\r\n";
        }
        $data .= 'Notifications-Count: 1' . "\r\n\r\n";
        $data .= 'Notification-Name: ' . $this->notification . "\r\n";
        $data .= 'Notification-Enabled: True' . "\r\n";
        $data .= "\r\n\r\n";
        $data .= 'Origin-Software-Name: growl.gntp.php' . "\r\n";
        $data .= 'Origin-Software-Version: 1.0' . "\r\n";
        $this->send($data);
    }
    
    public function notify($title, $text = '', $icon = null, $url = null)
    {
        $data  = 'GNTP/1.0 NOTIFY NONE ' . $this->createHash() . "\r\n";
        $data .= 'Application-Name: ' . $this->application . "\r\n";
        $data .= 'Notification-Name: ' . $this->notification . "\r\n";
        $data .= 'Notification-Title: ' . $title . "\r\n";
        $data .= 'Notification-Text: ' . $text . "\r\n";
        $data .= 'Notification-Sticky: False' . "\r\n";
        if ($icon != null) {
            $data .= 'Notification-Icon: ' . $icon . "\r\n";
        }
        if ($url != null) {
            $data .= 'Notification-Callback-Target-Method: GET' . "\r\n";
            $data .= 'Notification-Callback-Target: ' . $url . "\r\n";
        }
        $data .= "\r\n\r\n";
        $data .= 'Origin-Software-Name: growl.gntp.php' . "\r\n";
        $data .= 'Origin-Software-Version: 1.0' . "\r\n";
        $this->send($data);
    }
    
    public function send($data)
    {
        $fp = fsockopen($this->host, $this->port, $errno, $errstr, $this->time);
        if (!$fp) {
            echo $errstr . ' (' . $errno . ')';
        } else {
            fwrite($fp, $data);
            fread($fp, 12);
            fclose($fp);
        }
    }
}
