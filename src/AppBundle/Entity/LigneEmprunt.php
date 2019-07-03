<?php
/**
 * Created by PhpStorm.
 * User: gvecoven
 * Date: 19/05/2019
 * Time: 10:00
 */

namespace AppBundle\Entity;


class LigneEmprunt
{
    /**
     * @var int
     */
    private $idEmprunt;

    /**
     * @return int
     */
    public function getIdEmprunt()
    {
        return $this->idEmprunt;
    }

    /**
     * @param int $idEmprunt
     */
    public function setIdEmprunt($idEmprunt)
    {
        $this->idEmprunt = $idEmprunt;
    }

    /**
     * @return string
     */
    public function getConducteurName()
    {
        return $this->conducteurName;
    }

    /**
     * @param string $conducteurName
     */
    public function setConducteurName($conducteurName)
    {
        $this->conducteurName = $conducteurName;
    }

    /**
     * @return string
     */
    public function getDate_Depart()
    {
        return $this->date_depart;
    }

    /**
     * @param string $date_depart
     */
    public function setDate_Depart($date_depart)
    {
        $this->date_depart = $date_depart;
    }

    /**
     * @return string
     */
    public function getDate_Arriver()
    {
        return $this->date_arriver;
    }

    /**
     * @param string $date_arriver
     */
    public function setDate_Arriver($date_arriver)
    {
        $this->date_arriver = $date_arriver;
    }

    /**
     * @return string
     */
    public function getLieu_Depart()
    {
        return $this->lieu_depart;
    }

    /**
     * @param string $lieu_depart
     */
    public function setLieu_Depart($lieu_depart)
    {
        $this->lieu_depart = $lieu_depart;
    }

    /**
     * @return string
     */
    public function getLieu_Arriver()
    {
        return $this->lieu_arriver;
    }

    /**
     * @param string $lieu_arriver
     */
    public function setLieu_Arriver($lieu_arriver)
    {
        $this->lieu_arriver = $lieu_arriver;
    }

    /**
     * @var string
     */
    private $conducteurName;

    /**
 * @var string
 */
    private $date_depart;

    /**
     * @var string
     */
    private $date_arriver;

    /**
     * @var string
     */
    private $lieu_depart;

    /**
     * @var string
     */
    private $lieu_arriver;

}