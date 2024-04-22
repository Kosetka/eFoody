<?php


/**
 * usersmodel class
 */
class UsersModel
{

    use Model;

    protected $table = 'users';

    protected $allowedColumns = [
        'id',
        'email',
        'password',
        'date',
        'first_name',
        'last_name',
        'u_warehouse',
        'active',
        'u_role'
    ];

    public function getAllUsers(): array
    {
        $this->users = [];
        $array = [];
        $users = new UsersModel;
        $arr = $users->getAll($this->table);

        foreach ($arr as $user) {
            //foreach ($role as $r) {
            $user = (array) $user;
            $array[] = (array) $user;
            //}
        }
        $this->users = $array;
        //show($array);
        return $arr;
    }

}