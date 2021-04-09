<?php

/**
 * ユーザークラス
 * Class User
 */
class User
{
    protected $name;
    protected $age;

    function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getAge()
    {
        return $this->age;
    }
}

/**
 * 名簿クラス
 * Class Roster
 */
class Roster
{
    protected $userList = [];

    public function setUserList($user)
    {
        $this->userList[] = $user;
    }

    public function getUserList()
    {
        return $this->userList;
    }

}

$roster = new Roster();
$roster->setUserList(new User('name 01', 20));
$roster->setUserList(new User('name 02', 21));
$roster->setUserList(new User('name 03', 22));
$roster->setUserList(new User('name 04', 23));

foreach($roster->getUserList() as $user) {
    var_dump($user->getName(), $user->getAge());
}