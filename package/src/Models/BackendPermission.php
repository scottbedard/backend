<?php

namespace Bedard\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
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
     * Booted.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($model) {
            $model->purgeLesserPermissions();
        });
    }

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

    /**
     * Purge permissions that are subsets of the current model.
     *
     * @return void
     */
    public function purgeLesserPermissions()
    {
        if ($this->code === 'all') {
            $query = self::where('user_id', $this->user_id);

            if ($this->area !== 'all') {
                $query->where('area', $this->area);
            }
            
            $query->whereNot('id', $this->id)->delete();
        }
    }

    /**
     * Select permission by area.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $area
     *
     * @return void
     */
    public function scopeArea(Builder $query, string $area)
    {
        $query->where('area', self::normalize($area));
    }

    /**
     * Select permission by code.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $code
     *
     * @return void
     */
    public function scopeCode(Builder $query, string $code)
    {
        $query->where('code', self::normalize($code));
    }

    /**
     * Set a permission area.
     *
     * @param string $area
     *
     * @return void
     */
    public function setAreaAttribute(string $area)
    {
        $this->attributes['area'] = self::normalize($area);
    }

    /**
     * Set a permission code.
     *
     * @param string $code
     *
     * @return void
     */
    public function setCodeAttribute(string $code)
    {
        $this->attributes['code'] = self::normalize($code);
    }
}
