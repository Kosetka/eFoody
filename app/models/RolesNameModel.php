<?php


/**
 * roles_name class
 */
class RolesNameModel
{

    use Model;

    protected $table = 'roles_name';

    protected $allowedColumns = [
        'id',
        'role_name',
        'role_description',
        'r_active'
    ];

    public function getRoles(): array
    {
        $this->roles = [];
        $array = [];
        $roles = new RolesNameModel;
        $arr = $roles->getAll($this->table);

        foreach ($arr as $role) {
            //foreach ($role as $r) {
            $role = (array) $role;
            $array[] = (array) $role;
            //}
        }
        $this->roles = $array;
        //show($array);
        return $array;
    }

    public function getName($id): string
    {
        $role = new RolesNameModel;
        $role->first($id);
        return $role->role_name;
    }
}