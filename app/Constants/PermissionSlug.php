<?php
declare(strict_types=1);

namespace App\Constants;
final class PermissionSlug
{
    public const string USERS_VIEW_ANY = 'users_view_any';
    public const string USERS_VIEW = 'users_view';
    public const string USERS_SHOW = 'users_show';
    public const string USERS_CREATE = 'users_create';
    public const string USERS_UPDATE = 'users_update';
    public const string USERS_DELETE = 'users_delete';

    public const string SITES_VIEW_ANY = 'sites_view_any';
    public const string SITES_VIEW = 'sites_view';
    public const string SITES_SHOW = 'sites_show';
    public const string SITES_CREATE = 'sites_create';
    public const string SITES_UPDATE = 'sites_update';
    public const string SITES_DELETE = 'sites_delete';



    public static function toArray(): array
    {
        return(new \ReflectionClass(self::class))->getConstants();
    }
}
