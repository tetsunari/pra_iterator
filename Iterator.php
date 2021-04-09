<?php

/**
 * ユーザークラス
 * Class User
 */
class User
{
    protected $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
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
// var_dump($roster);
$roster->setUserList(new User('name 01'));
$roster->setUserList(new User('name 02'));
$roster->setUserList(new User('name 03'));
$roster->setUserList(new User('name 04'));

foreach($roster->getUserList() as $user) {
    var_dump($user->getName());
}