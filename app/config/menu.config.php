<?php
$DashboardNav = array(
    array(
        'name'      => $this->translate('Dashboard'),
        'icon'      => 'fas fa-house',
        'url'       => 'admin',
        'main'      => 'main',
        'icon'      => 'dashboard',
    ),
    array(
        'header'    => $this->translate('Multimedia'),
    ),
    array(
        'name'      => $this->translate('Movies'), 
        'url'       => 'admin/movies',
        'main'      => 'movies',
        'icon'      => 'movie'
    ),
    array(
        'name'      => $this->translate('TV Shows'), 
        'url'       => 'admin/series',
        'main'      => 'series',
        'icon'      => 'tv',
        'sub' => array(
            array(
                'name' => $this->translate('TV Shows'),
                'url' => 'admin/series',
                'main' => 'series'
            ),
            array(
                'name' => $this->translate('Episodes'),
                'url' => 'admin/episodes',
                'main' => 'series'
            ),
        )
    ),
    array(
        'name'      => $this->translate('Genres'), 
        'url'       => 'admin/genres',
        'main'      => 'genres',
        'icon'      => 'genre',
    ),
    array(
        'name'      => $this->translate('Peoples'), 
        'url'       => 'admin/peoples',
        'main'      => 'peoples',
        'icon'      => 'people',
    ),
    array(
        'name'      => $this->translate('Platforms'), 
        'url'       => 'admin/platforms',
        'main'      => 'platforms',
        'icon'      => 'platform',
    ),
    array(
        'header' => $this->translate('Community'),
        'class' => 'mt-3',
    ),
    array(
        'name'      => $this->translate('Collections'), 
        'url'       => 'admin/collections',
        'main'      => 'collections',
        'icon'      => 'collection',
    ),
    array(
        'name' => $this->translate('Comments'), 
        'url' => 'admin/comments',
        'subtext' => 'comment available',
        'main' => 'comments',
        'icon' => 'comment',
    ),
    array(
        'name' => $this->translate('Requests'), 
        'url' => 'admin/requests',
        'main' => 'requests',
        'icon' => 'request',
    ),
    array(
        'name' => $this->translate('Reports'), 
        'url' => 'admin/reports',
        'subtext' => 'report pending',
        'main' => 'reports',
        'icon' => 'report',
    ),
    array(
        'name' => $this->translate('Community'), 
        'url' => 'admin/community',
        'main' => 'community',
        'icon' => 'discussion',
    ),
    array(
        'name' => $this->translate('Users'), 
        'url' => 'admin/users',
        'main' => 'users',
        'icon' => 'user',
    ),
    array(
        'header' => $this->translate('Settings'),
        'class' => 'mt-3',
    ),
    array(
        'name' => $this->translate('Tools'), 
        'url' => 'admin/tools',
        'main' => 'tools',
        'icon' => 'tool',
    ),
    array(
        'name' => $this->translate('Settings'),
        'url'   => 'admin/settings',
        'main' => 'settings',
        'icon' => 'settings',
        'sub' => array(
            array(
                'name' => $this->translate('General'),
                'url' => 'admin/settings',
                'main' => 'settings'
            ),
            array(
                'name' => $this->translate('Advertisements'),
                'url' => 'admin/ads',
                'main' => 'settings'
            ),
            array(
                'name' => $this->translate('Countries'),
                'url' => 'admin/countries',
                'main' => 'settings'
            ),
            array(
                'name' => $this->translate('Languages'),
                'url' => 'admin/languages',
                'main' => 'settings'
            ),
            array(
                'name' => $this->translate('Pages'),
                'url' => 'admin/pages',
                'main' => 'settings'
            ),
            array(
                'name' => $this->translate('Clear cache'),
                'url' => 'admin/clear-cache',
                'main' => 'settings'
            ),
        )
    )
);