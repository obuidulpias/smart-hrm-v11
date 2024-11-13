<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
    public function userAll()
    {
        $user = $this->user->allUserInfo();
        $age = $this->getAge(1);
        $users['user'] = $user;
        $users['age'] = $age;
        return apiResponse($users, 'Data found', 'Success');
    }
}
