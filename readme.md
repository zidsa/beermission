## Beermission

Simple and flexible roles & permission system.

## Usage

Once your Bearer entity is set up, you can determine if it should be granted access to your protected resource in the
following fashion.

```php
$acl->bearer($bearer)
            ->withRole('RoleGrant', 'RoleScope', 'RoleScopeValue')
            ->withPermission('PermissionGrant', 'PermissionScope', 'PermissionScopeValue')
            ->grantAccessWhen()
            ->hasEveryGrant();
```

> Important note: the syntax is most likely going to change.
