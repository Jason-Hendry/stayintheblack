<?php
namespace Application\Entities;

/** @Entity @Table(name="usr") */
class User
{
  /** @Id @Column(type="integer") @AutoGenerated */
  protected $idusr;

  /** @Column(type="string") */
  protected $username;
  public function getUsername() { return $this->username; }

  /** @Column(type="string") */
  protected $password;
  public function getPassword() { return $this->password; }

}