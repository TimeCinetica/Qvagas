<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Services\RaceService;
use App\Services\UserService;
use App\Services\UtilsService;
use App\Services\VacancyTypeService;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Spatie\Fractal\Facades\Fractal;

class UserWebController extends Controller
{
    protected $userService;
    protected $vacancyTypeService;
    protected $raceService;
    protected $utilsService;

    public function __construct(
        UserService $userService,
        VacancyTypeService $vacancyTypeService,
        RaceService $raceService,
        UtilsService $utilsService
    ) {
        $this->userService = $userService;
        $this->vacancyTypeService = $vacancyTypeService;
        $this->raceService = $raceService;
        $this->utilsService = $utilsService;
    }

    /**
     * 
     */
    public function renderSignup()
    {
        $vacancyTypes = $this->vacancyTypeService->index();
        $races = $this->raceService->index();

        return view('user.signup', ['vacancyTypes' => $vacancyTypes, 'races' => $races]);
    }

    /**
     * 
     */
    public function renderNewPasswordFromForgot()
    {
        return view('auth.newPassword');
    }


    /**
     * 
     */
    public function renderDelete()
    {
        return view('user.delete');
    }

    /**
     * 
     */
    public function renderChangePassword()
    {
        return view('user.changePassword');
    }

    /**
     * 
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $this->userService->changePassword($request);

        $transformer = new UserTransformer();
        return Fractal::item($user)
            ->transformWith($transformer)
            ->toArray();
    }

    /**
     * 
     */
    public function userInfos()
    {
        $infos = $this->userService->userInfos();
        return response()->json($infos, 200);
    }

    /**
     * 
     */
    public function delete(Request $request)
    {
        $user = $this->userService->delete($request);

        return $user;
    }

    /**
     * 
     */
    public function indexStates()
    {
        $states = $this->utilsService->indexStates();
        return response()->json($states, 200);
    }

    /**
     * 
     */
    public function indexCitiesByState($stateId)
    {
        $cities = $this->utilsService->indexCitiesByState($stateId);

        return response()->json($cities, 200);
    }
}
