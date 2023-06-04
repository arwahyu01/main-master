<?php

/**
 * Created by @arwahyupradana
 * Description: this file is used for creating access menu for user group in application
 * this file is used on database seeder \Database\Seeds\AccessMenuSeeder.php
 */

return [
    'access'=>[
        'root'    =>[
            'dashboard', 'master', 'user', 'menu', 'level', 'access-group', 'access-menu','faq','question','pengumuman'
        ], 'admin'=>[
            'dashboard', 'master', 'user','question',
        ], 'user' =>[
            'dashboard','question'
        ],
    ],
    'crud'=>[
        'create', 'read', 'update', 'delete'
    ],
];
