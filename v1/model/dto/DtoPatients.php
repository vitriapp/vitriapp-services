<?php
/**
 * PHP version 7.4
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @Date:    2021/8/8 7:9:50
 * @link     https://www.vitriapp.com PHP License 1.0
 */

namespace services\v1\model\dto;

/**
 * Dto Patients
 *
 * @category Developer
 * @package  Vitriapp
 * @author   Mario Alejandro Benitez Orozco <maalben@gmail.com>
 * @license  Commercial PHP License 1.0
 * @link     https://www.vitriapp.com PHP License 1.0
 */
class DtoPatients
{
    private int    $codeUser  = 0;
    private string $identity  ='';
    private string $nameUser  ='';
    private string $address   ='';
    private string $postal    ='';
    private string $gender    ='';
    private string $telephone ='';
    private string $birth     ='0000-00-00';
    private string $email     ='';

    /**
     * @return int
     */
    final public function getCodeUser(): int
    {
        return $this->codeUser;
    }

    /**
     * @param int $codeUser
     */
    final public function setCodeUser(int $codeUser): void
    {
        $this->codeUser = $codeUser;
    }

    /**
     * @return string
     */
    final public function getIdentity(): string
    {
        return $this->identity;
    }

    /**
     * @param string $identity
     */
    final public function setIdentity(string $identity): void
    {
        $this->identity = $identity;
    }

    /**
     * @param string $nameUser
     */
    final public function setNameUser(string $nameUser): void
    {
        $this->nameUser = $nameUser;
    }

    /**
     * @return string
     */
    final public function getNameUser(): string
    {
        return $this->nameUser;
    }

    /**
     * @return string
     */
    final public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    final public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    final public function getPostal(): string
    {
        return $this->postal;
    }

    /**
     * @param string $postal
     */
    final public function setPostal(string $postal): void
    {
        $this->postal = $postal;
    }

    /**
     * @return string
     */
    final public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    final public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    final public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    final public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    final public function getBirth(): string
    {
        return $this->birth;
    }

    /**
     * @param string $birth
     */
    final public function setBirth(string $birth): void
    {
        $this->birth = $birth;
    }

    /**
     * @return string
     */
    final public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    final public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
