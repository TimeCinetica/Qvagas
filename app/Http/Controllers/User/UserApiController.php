<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordForgotRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserPhotosRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Spatie\Fractal\Facades\Fractal;

/**
 * @group User
 */
class UserApiController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Cadastro de usuário
     * 
     * @authenticated
     * 
     * @transformer 201 App\Transformers\UserTransformer
     * @transformModel App\Models\User
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store($request);

        $transformer = new UserTransformer();
        return Fractal::item($user)
            ->transformWith($transformer)
            ->toArray();
    }

    /**
     * Atualização de usuário e curriculo
     * 
     * @authenticated
     * 
     * @transformer 200 App\Transformers\UserTransformer
     * @transformModel App\Models\User
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $this->userService->update($request);

        $transformer = new UserTransformer();
        return Fractal::item($user)
            ->transformWith($transformer)
            ->toArray();
    }

    /**
     * 
     */
    public function updatePhotos(UpdateUserPhotosRequest $request)
    {
        $user = $this->userService->updatePhotos($request);

        $transformer = new UserTransformer();
        return Fractal::item($user)
            ->transformWith($transformer)
            ->toArray();
    }

    /**
     * @hideFromAPIDocumentation
     * 
     * Altera senha de usuário
     */
    public function newPasswordFromForgot(NewPasswordForgotRequest $request)
    {
        $user = $this->userService->newPasswordFromForgot($request);
        return response()->json($user, 200);
    }
}
