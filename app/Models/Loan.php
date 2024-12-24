<?php

namespace App\Models;
use Ramsey\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!isset($this->attributes['id'])) {
            $this->attributes['id'] = Uuid::uuid4()->toString();
        }
    }

    protected $fillable = ['user_id', 'amount', 'monthly_income', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
