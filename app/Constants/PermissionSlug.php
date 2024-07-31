<?php
declare(strict_types=1);

namespace App\Constants;

final class PermissionSlug
{
    public const USERS_VIEW_ANY = 'users_view_any';
    public const USERS_VIEW = 'users_view';
    public const USERS_CREATE = 'users_create';
    public const USERS_UPDATE = 'users_update';
    public const USERS_DELETE = 'users_delete';

    public const SITES_VIEW_ANY = 'sites_view_any';
    public const SITES_VIEW = 'sites_view';
    public const SITES_CREATE = 'sites_create';
    public const SITES_UPDATE = 'sites_update';
    public const SITES_DELETE = 'sites_delete';

    public const ROLES_VIEW_ANY = 'roles_view_any';
    public const ROLES_VIEW = 'roles_view';
    public const ROLES_CREATE = 'roles_create';
    public const ROLES_UPDATE = 'roles_update';
    public const ROLES_DELETE = 'roles_delete';

    public const PAYMENTS_VIEW_ANY = 'payments_view_any';
    public const PAYMENTS_VIEW = 'payments_view';
    public const PAYMENTS_CREATE = 'payments_create';
    public const PAYMENTS_UPDATE = 'payments_update';
    public const PAYMENTS_DELETE = 'payments_delete';
    public const VIEW_TRANSACTIONS = 'view_transactions';

    public static function toArray(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }
}
