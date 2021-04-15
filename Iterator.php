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
 * Iterator Class
 * Class UserListIterator
 */
class UserListIterator implements UserListIteratorInterface {

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

    public function next()
    {
        return $this->users[$this->position++];
    }
}

/**
 * 集約オブジェクト
 * Aggregate Class
 * Class UsersAggregate
 */
class UsersAggregate implements UsersAggregateInterface {

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
            echo sprintf("%s", $user);
            echo "<br>";
        }
    }
}

$users = [ "name 01", "name 02", "name 03", "name 04", "name 05" ];
$list = new RosterClient(new UsersAggregate($users));

echo $list->getUsers()