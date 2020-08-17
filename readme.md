## Beermission

Simple and flexible roles & permission system.

## Usage

Once your Bearer entity is set up, you can determine if it should be granted access to your protected resource in the
following fashion.

```php
$this->acl
    ->bearer($this->bearer)
    ->that(static function (RequiredGrantBuilder $grantBuilder): void {
        $grantBuilder->hasRole('Role', 'RoleScope', 'RoleScopeValue');
        $grantBuilder->hasPermission('Permission', 'PermissionScope', 'PermissionScopeValue');
    })
    ->shouldBeGrantedAccessWhen()
    ->hasAllExpectedGrants();
```

> Important note: the syntax is most likely going to change.

