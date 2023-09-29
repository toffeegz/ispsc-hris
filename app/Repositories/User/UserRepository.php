<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */

    public function __construct(User $model)
    {
        parent::__construct($model);
    }
 
    public function getByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getByToken(string $token)
    {
        return $this->model->where('verification_token', $token)->first();
    }
}
