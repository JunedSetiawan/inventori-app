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
                        'icon' => @svg('heroicon-o-inbox-stack'),
                        'menus' => [],
                    ],
                ],
            ],
            [
                'title' => 'Sales',
                'permissions' => 'view-sales',
                'menus' => [
                    [
                        'title' => 'Sales',
                        'route' => '',
                        'icon' => @svg('heroicon-o-banknotes'),
                        'menus' => [
                            [
                                'title' => 'Sale Items',
                                'route' => 'sales.index',
                                'icon' => '',
                            ],
                            [
                                'title' => 'Sale Histories',
                                'route' => 'sales.history',
                                'icon' => '',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Purchase',
                'permissions' => 'view-purchase',
                'menus' => [
                    [
                        'title' => 'Purchase',
                        'route' => '',
                        'icon' => @svg('heroicon-o-shopping-cart'),
                        'menus' => [
                            [
                                'title' => 'Purchase Items',
                                'route' => 'purchase.index',
                                'icon' => '',
                            ],
                            [
                                'title' => 'Purchase Histories',
                                'route' => 'purchase.history',
                                'icon' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
