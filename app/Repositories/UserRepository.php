<?php
/**
 * Created by PhpStorm.
 * User: jj
 * Date: 2017/3/2
 * Time: 10:14
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    public function byId($id){
        return User::find($id);
    }
}