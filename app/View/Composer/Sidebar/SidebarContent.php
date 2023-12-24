<?php

namespace App\View\Composer\Sidebar;


class SidebarContent
{

    public static function hasActiveChild($menus)
    {
        foreach ($menus as $menu) {
            if (request()->routeIs($menu['route']) || (isset($menu['menus']) && static::hasActiveChild($menu['menus']))) {
                return true;
            }
        }
        return false;
    }

    public static function dashboard()
    {
        return [
            [
                'title' => 'Dashboard',
                'permissions' => '',
                'menus' => [
                    [
                        'title' => 'Dashboard',
                        'route' => 'dashboard',
                        'icon' => @svg('heroicon-o-home'),
                        'menus' => [],
                    ],
                ],
            ],
            [
                'title' => 'Inventories',
                'permissions' => 'view-inventory',
                'menus' => [
                    [
                        'title' => 'Inventories',
                        'route' => 'inventory.index',
                        'icon' => @svg('heroicon-o-home'),
                        'menus' => [],
                    ],
                ],
            ],

        ];
    }
}
