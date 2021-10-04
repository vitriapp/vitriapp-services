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
     * Get code user
     *
     * This method is useful for get code user
     *
     * @return int
     */
    final public function getCodeUser(): int
    {
        return $this->codeUser;
    }

    /**
     * Set code user
     *
     * This method is useful for set code user
     *
     * @param  int $codeUser
     *
     * @return void
     */
    final public function setCodeUser(int $codeUser): void
    {
        $this->codeUser = $codeUser;
    }

    /**
     * Get identity
     *
     * This method is useful for get identity
     *
     * @return string
     */
    final public function getIdentity(): string
    {
        return $this->identity;
    }

    /**
     * Set identity
     *
     * This method is useful for set identity
     *
     * @param string $identity
     */
    final public function setIdentity(string $identity): void
    {
        $this->identity = $identity;
    }

    /**
     * Set name user
     *
     * This method is useful for get name user
     *
     * @param string $nameUser
     */
    final public function setNameUser(string $nameUser): void
    {
        $this->nameUser = $nameUser;
    }

    /**
     * Get name user
     *
     * This method is useful for get name user
     *
     * @return string
     */
    final public function getNameUser(): string
    {
        return $this->nameUser;
    }

    /**
     * Get address
     *
     * This method is useful for get address
     *
     * @return string
     */
    final public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * This method is useful for set address
     *
     * @param string $address
     */
    final public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * Get postal
     *
     * This method is useful for get postal
     *
     * @return string
     */
    final public function getPostal(): string
    {
        return $this->postal;
    }

    /**
     * Set postal
     *
     * This method is useful for set postal
     *
     * @param string $postal
     */
    final public function setPostal(string $postal): void
    {
        $this->postal = $postal;
    }

    /**
     * Get gender
     *
     * This method is useful for get gender
     *
     * @return string
     */
    final public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * Set gender
     *
     * This method is useful for set gender
     *
     * @param string $gender
     */
    final public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * Get telephone
     *
     * This method is useful for get telephone
     *
     * @return string
     */
    final public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * Set telephone
     *
     * This method is useful for set telephone
     *
     * @param string $telephone
     */
    final public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * Get birth
     *
     * This method is useful for get birth
     *
     * @return string
     */
    final public function getBirth(): string
    {
        return $this->birth;
    }

    /**
     * Set birth
     *
     * This method is useful for set birth
     *
     * @param string $birth
     */
    final public function setBirth(string $birth): void
    {
        $this->birth = $birth;
    }

    /**
     * Get email
     *
     * This method is useful for get email
     *
     * @return string
     */
    final public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * This method is useful for set email
     *
     * @param string $email
     */
    final public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
