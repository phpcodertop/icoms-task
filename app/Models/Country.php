<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function users()
    {
        $users = collect([]);
        $this->companies()->each(function ($company) use($users) {
            $users->add($company->users);
        });
        return $users->unique('id')->flatten();
    }
}
