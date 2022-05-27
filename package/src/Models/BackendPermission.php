<?php

namespace Bedard\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BackendPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'area',
        'code',
        'user_id',
    ];

    /**
     * Normalize an area / code value.
     *
     * @param string $str
     *
     * @return string
     */
    public static function normalize(string $str): string
    {
        return strtolower(trim(Str::snake($str)));
    }
}
