<?php

namespace Bedard\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BackendPermission extends Model
{
    use HasFactory;

    /**
     * Grant backend permission to a user.
     *
     * @param int $userId
     * @param string $area
     * @param string $code
     *
     * @return \Bedard\Backend\Models\BackendPermission
     */
    public static function grant(int $userId, string $area, string $code)
    {
        $area = self::normalizeArea($area);
        $code = self::normalizeArea($code);
        
        $permission = self::query()
            ->where('user_id', $userId)
            ->where('area', $area)
            ->where('code', $code)
            ->firstOrNew();

        if ($permission->id) {
            return $permission;
        }

        $permission->user_id = $userId;
        $permission->area = $area;
        $permission->code = $code;
        $permission->save();

        return $permission;
    }

    /**
     * Normalize a permission area.
     *
     * @param string $area
     *
     * @return string
     */
    public static function normalizeArea(string $area)
    {
        return Str::snake(trim(stripslashes($area)));
    }

    /**
     * Normalize a permission code.
     *
     * @param string $code
     *
     * @return string
     */
    public static function normalizeCode(string $code)
    {
        return trim(strtolower($code));
    }
}
