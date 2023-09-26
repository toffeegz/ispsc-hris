<?php

namespace App\Repositories\Verification;

use App\Models\Verification;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VerificationRepository extends BaseRepository implements VerificationRepositoryInterface
{

    /**
     * VerificationRepository constructor.
     *
     * @param Verification $model
     */

    public function __construct(Verification $model)
    {
        parent::__construct($model);
    }

    public function createVerification(string $user_id, string $type)
    {
        $token = Str::random(64);
        // $hashedToken = Hash::make($token);

        return $this->create([
            'user_id' => $user_id,
            'token' => $token,
            'type' => $type
        ]);
    }
}
