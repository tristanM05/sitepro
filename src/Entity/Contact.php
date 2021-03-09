<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact{

        /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private $mail;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10, minMessage="Votre message doit contenir au moins 10 charactères")
     */
    private $message;

    /**
     * @var checkbox|null
     * 
     */
    private $check;

    /**
     * Get the value of message
     *
     * @return  string|null
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param  string|null  $message
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of mail
     *
     * @return  string|null
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @param  string|null  $message
     *
     * @return  self
     */ 
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }
    /**
     * Get the value of property
     *
     * @return  Property|null
     */ 
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Get the value of check
     *
     * @return  string|null
     */ 
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * Set the value of message
     *
     * @param  checkbox|null  $check
     *
     * @return  self
     */ 
    public function setCheck($check)
    {
        $this->check = $check;

        return $this;
    }

}