<?php

namespace App\Modules\V1\Auth\Domain\Jobs;

use App\Modules\V1\User\Repository\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class DeleteToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private $email)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserRepository $userRepo, TokenRepository $accessTokenRepo, RefreshTokenRepository $refreshTokenRepo)
    {
        DB::beginTransaction();
        try {
            $user = $userRepo->findWhere(['email' => $this->email])->first()->id;
            $accessToken = $accessTokenRepo->forUser($user);
            foreach ($accessToken as $token) {
                $accessTokenRepo->revokeAccessToken($token['id']);
                $refreshTokenRepo->revokeRefreshTokensByAccessTokenId($token['id']);
            }
        } catch (\Exception) {
            DB::rollBack();
        }
        DB::commit();
    }
}
