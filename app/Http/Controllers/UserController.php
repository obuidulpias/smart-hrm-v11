<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\UserTraits;

class UserController extends Controller
{
    use UserTraits;

    protected $user;
    public function __construct(User $user)
    {
        $this->user = new UserRepository($user);
    }
    public function info()
    {
        $user = $this->user->allUserInfo();
        $age = $this->getAge(1);
        $users['user'] = $user;
        $users['age'] = $age;
        return apiResponse($users);
    }
}
