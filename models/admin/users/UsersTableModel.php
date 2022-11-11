<?php

namespace app\models\admin\users;

use app\models\DbTableModel;

class UsersTableModel extends DbTableModel
{
    public const ADMIN_EDIT_PATH = '/admin/users/edit/';
    public function gridAttrbiutes(): array
    {
        return [
            'user_id',
            'username',
            'name'
        ];
    }

    public function gridAttributeLabels(): array
    {
        return [
            'user_id' => "User ID",
            'username' => "Username",
            'name' => "Name"
        ];
    }
    public function getPrimaryKey(): string
    {
        return 'user_id';
    }
}
