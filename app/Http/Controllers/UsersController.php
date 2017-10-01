<?php

namespace App\Http\Controllers;

use Phalcon\Mvc\Controller;
use App\Models\Users;

class UsersController extends Controller
{
    public function get($id)
    {

        $user = Users::findFirst();

        $this->res->end(
          $this->view->render(
            'users/show',
            [
                'user' => $user,
            ]
        )
      );

    }

    public function add($payload)
    {
        $this->res->end($payload);
    }
}
