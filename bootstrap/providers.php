<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\Filament\AppPanelProvider::class,
    Ardiansyahirwan\FilamentRolePermission\CustomPermissionServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
];
