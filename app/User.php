<?php

namespace App;

//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\LeaderBoard;
class User extends Authenticatable implements JWTSubject
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','user_type','device_type','login_by','picture','is_activated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [
            'userId' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->picture,
        ];
    }


    public function userHistory()
    {
        return $this->hasMany('App\UserHistory');
    }

    public function userRating()
    {
        return $this->hasMany('App\UserRating');
    }

    public function userWishlist()
    {
        return $this->hasMany('App\Wishlist');
    }

    public function userPayment()
    {
        return $this->hasMany('App\UserPayment');
    }



    public function leaderboard(){
        return $this->hasMany(LeaderBoard::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function livequiz(){
        return $this->hasMany(Livequiz::class);
    }

    public function liveQuizCorrectUsers(){
        return $this->hasMany(LiveQuizCorrectUser::class);
    }

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }

    public function spinnerLeaderBoards()
    {
        $this->hasMany(SpinnerLeaderboard::class);
    }

    public function spinnerDailyPoints()
    {
        return $this->hasMany(SpinnerDailyPoint::class);
    }
    
    public function audition()
    {
        return $this->hasOne(Audition::class);
    }

    public function amoutnWithDraw()
    {
        return $this->hasMany(LeaderAmountWithDraw::class);
    }
    public static function boot()
    {
        //execute the parent's boot method 
        parent::boot();

        //delete your related models here, for example
        static::deleting(function($user)
        {

            foreach($user->userHistory as $history)
            {
                $history->delete();
            } 

            foreach($user->userRating as $rating)
            {
                $rating->delete();
            } 

            foreach($user->userWishlist as $wishlist)
            {
                $wishlist->delete();
            } 

            foreach($user->userPayment as $payment)
            {
                $payment->delete();
            } 
        }); 

    }

}
