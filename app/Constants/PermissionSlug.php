<?php
declare(strict_types=1);

namespace App\Constants;
use Illuminate\Support\Facades\Lang;

final class PermissionSlug
{
    public const string USERS_VIEW_ANY = 'users_view_any';
    public const string USERS_VIEW = 'users_view';
    public const string USERS_CREATE = 'users_create';
    public const string USERS_UPDATE = 'users_update';
    public const string USERS_DELETE = 'users_delete';

    public const string SITES_VIEW_ANY = 'sites_view_any';
    public const string SITES_VIEW = 'sites_view';
    public const string SITES_CREATE = 'sites_create';
    public const string SITES_UPDATE = 'sites_update';
    public const string SITES_DELETE = 'sites_delete';

    public const string ROLES_VIEW_ANY = 'roles_view_any';
    public const string ROLES_VIEW = 'roles_view';
    public const string ROLES_CREATE = 'roles_create';
    public const string ROLES_UPDATE = 'roles_update';
    public const string ROLES_DELETE = 'roles_delete';

    public const string PAYMENTS_VIEW_ANY = 'payments_view_any';
    public const string PAYMENTS_VIEW = 'payments_view';
    public const string PAYMENTS_CREATE = 'payments_create';
    public const string PAYMENTS_UPDATE = 'payments_update';
    public const string PAYMENTS_DELETE = 'payments_delete';
    public const string VIEW_TRANSACTIONS = 'view_transactions';

    public static function toArray(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }

}
