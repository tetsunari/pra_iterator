<?php

/**
 * Aggregate Interface
 * Interface UsersAggregate
 */
interface UsersAggregateInterface {
    public function createIterator();
}

/**
 * Iterator Interface
 * Interface UserListIterator
 */
interface UserListIteratorInterface {
    public function hasNext();

    public function next();
}

/**
 * イテレータの共通処理
 * Trait SuperUserList
 */
trait SuperUserList
{
    private $users;
    private $position = 0;

    function __construct($users)
    {
        $this->users = $users;
    }

    public function hasNext()
    {
        return isset($this->users[$this->position]);
    }
}

/**
 * 名前のみを返すイテレータ
 * Iterator Class
 * Class UserListNameIterator
 */
class UserListNameIterator implements UserListIteratorInterface {

    use SuperUserList;

    public function next()
    {
        return $this->users[$this->position++];
    }
}

/**
 * 名前と年齢を返すイテレータ
 * Iterator Class
 * Class UserListIterator
 */
class UserListIterator implements UserListIteratorInterface {

    use SuperUserList;

    public function next()
    {
        $user = $this->users[$this->position++];
        return sprintf("%s (%s)", $user['name'], $user['age']);
    }
}

/**
 * 集約オブジェクトの共通処理
 * Trait SuperUsersAggregate
 */
trait SuperUsersAggregate
{
    private $userList;

    function __construct($users)
    {
        $this->userList = $users;
    }

    public function addUsersList($user)
    {
        $this->userList[] = $user;
    }

    public function getUserList()
    {
        return $this->userList;
    }
}

/**
 * 集約オブジェクト
 * Aggregate Class
 * Class UsersAggregate
 */
class UsersNameAggregate implements UsersAggregateInterface {

    use SuperUsersAggregate;

    public function createIterator()
    {
        return new UserListNameIterator($this->userList);
    }
}

class UsersAggregate implements UsersAggregateInterface {

    use SuperUsersAggregate;

    public function createIterator()
    {
        return new UserListIterator($this->userList);
    }
}

/**
 * クライアント
 * Client Class
 * Class RosterClient
 */
class RosterClient {

    private $userIterator;

    function __construct(UsersAggregateInterface $user_list)
    {
        $this->userIterator = $user_list->createIterator();
    }

    function getUsers()
    {
        while ($this->userIterator->hasNext()) {
            $user = $this->userIterator->next();
            echo $user;
            echo "<br>";
        }
    }
}

$users_01 = ["name 01", "name 02", "name 03", "name 04"];
$users_02 = [
    ["name" => "name 01", "age" => 20],
    ["name" => "name 02", "age" => 21],
    ["name" => "name 03", "age" => 22],
    ["name" => "name 04", "age" => 23]
];


$list = new RosterClient(new UsersNameAggregate($users_01));

echo $list->getUsers();

$list = new RosterClient(new UsersAggregate($users_02));

echo $list->getUsers();