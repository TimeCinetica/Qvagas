<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf',
        'birthDate',
        'cellphone',
        'cellphone2',
        'email',
        'password',
        'roleId',
        'schooling',
        'cep',
        'address',
        'number',
        'district',
        'cityId',
        'stateId',
        'sex',
        'otherSex',
        'rg',
        'rgStateId',
        'father',
        'mother',
        'civil',
        'otherCivil',
        'volunteerWork',
        'otherVolunteerWork',
        'hasChildren',
        'otherHasChildren',
        'whoHelps',
        'accident',
        'smoke',
        'timeAvailability',
        'workWeekends',
        'missWork',
        'hobbies',
        'availableTravel',
        'photo',
        'raceId',
        'pcdReport',
        'evaluated', // Avaliado pela equipe QVagas
        'stamped', // Selo de Talentos do LabCarreiras,
        'passwordResetedAt',
        'admin_responsed',
        'job'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 
     */
    public function getJWTCustomClaims()
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email
        ];
    }

    /**
     * 
     */
    public function isSadmin()
    {
        return $this->roleId == Role::SuperAdmin;
    }

    /**
     * 
     */
    public function isAdmin()
    {
        return $this->roleId == Role::Admin || $this->roleId == Role::SuperAdmin;
    }

    /**
     * 
     */
    public function isUser()
    {
        return $this->roleId == Role::User;
    }

    /**
     * 
     */
    public function isCollaborator()
    {
        return $this->roleId == Role::collaborator;
    }


    /**
     * Hash the password.
     *
     * @param string $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    ///////////////////////////
    ///      Relations      ///
    ///////////////////////////

    /**
     * User role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'roleId');
    }

    /**
     * User confirmation code
     */
    public function confirmation()
    {
        return $this->hasOne(Confirmation::class, 'userId');
    }

    /**
     * User curriculum
     */
    public function resume()
    {
        return $this->hasOne(Resume::class, 'userId');
    }

    /**
     * 
     */
    public function race()
    {
        return $this->belongsTo(Race::class, 'raceId');
    }

    /**
     * 
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'stateId');
    }

    /**
     * 
     */
    public function rgState()
    {
        return $this->belongsTo(State::class, 'rgStateId');
    }

    /**
     * 
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'cityId');
    }

    /**
     * 
     */
    public function paycheck()
    {
        return $this->hasMany(Paycheck::class, 'nameUser');
    }
}
