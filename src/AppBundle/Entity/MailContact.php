<?php
/**
 * Created by PhpStorm.
 * User: gvecoven
 * Date: 07/05/2019
 * Time: 10:56
 */

namespace AppBundle\Entity;



class MailContact
{
    /**
     * @var string
     *
     */
    private $mail;

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }
}