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
    private $mailContact;

    /**
     * @return string
     */
    public function getMailContact()
    {
        return $this->mailContact;
    }

    /**
     * @param string $mailContact
     */
    public function setMailContact($mailContact)
    {
        $this->mailContact = $mailContact;
    }
}