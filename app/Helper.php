<?php

use App\Model\RoleHasPermission;

function datetimeIdFormat($datetimeString) {
    if ($datetimeString == '') return '';
    if ($datetimeString == null) return '';

    $explodeDatetime = explode(' ',$datetimeString);
    $date = $explodeDatetime[0];
    $time = $explodeDatetime[1];

    $explodeDate = explode('-',$date);
    $year = $explodeDate[0];

    $months = [
        '',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Agt',
        'Sep',
        'Okt',
        'Nov',
        'Des'
    ];

    $month = $months[(int) $explodeDate[1]];
    $day = $explodeDate[2];

    $idDateFormat = $day . ' ' . $month . ' ' . $year . ' - ' . $time;
    return $idDateFormat;
}

function menu() {
    $getMenu = DB::table('module')->where('parent_id', null)->get();

    $menu = '';
    if (count($getMenu) > 0) {
        foreach ($getMenu as $gmn) {
            $submenu = '';
            $getSubmenu = DB::table('module')->where('parent_id', $gmn->id)->get();
            if (count($getSubmenu) > 0) {
                foreach ($getSubmenu as $gsm) {
                    $submenu .= '
                    <li>
                        <a class="dropdown-item" href="'. url($gsm->url) .'">
                            '. $gsm->name .'
                        </a>
                    </li>';
                }
            }
            
            $submenuTotal = count($getSubmenu);
            $isDropdown = $submenuTotal > 0 ? 'dropdown' : '';
            $menu .= '
            <li class="nav-item '. $isDropdown .'">
                <a class="nav-link ' . ($submenuTotal > 0 ? 'dropdown-toggle' : '' ) . '"  href="'. ($submenuTotal > 0 ? '#navbar-layout': url($gmn->url)) .'" ' . ($submenuTotal > 0 ? 'data-toggle="dropdown" role="button" aria-expanded="false"': '') . '>
                    <span class="nav-link-title">
                    '. $gmn->name .'
                    </span>
                </a>
                <ul class="dropdown-menu">
                    '. $submenu .'
                </ul>
            </li>';
        }
    }

    echo $menu;
}

function hasPermission(String $permissionName, String $returnType = 'redirect') {
    $permissionId = 0;
    switch ($permissionName) {
        case 'CREATE_NEW_TOPIC':
            $permissionId = 1;
            break;

        case 'VIEW_TOPIC_LIST':
            $permissionId = 2;
            break;

        case 'UPDATE_TOPIC_SETTING':
            $permissionId = 3;
            break;

        case 'UPDATE_TOPIC_CONTENT':
            $permissionId = 4;
            break;

        case 'DELETE_TOPIC':
            $permissionId = 5;
            break;

        case 'VIEW_USER_LIST':
            $permissionId = 6;
            break;

        case 'CREATE_NEW_USER':
            $permissionId = 7;
            break;

        case 'UPDATE_USER':
            $permissionId = 8;
            break;

        case 'DELETE_USER':
            $permissionId = 9;
            break;

        case 'MANAGE_USER_PERMISSION':
            $permissionId = 10;
            break;
        
        default:
            $permissionId = 0;
            break;
    }

    $roleId = Auth::user()->role_id;
    $checkPermission = RoleHasPermission::where([
                            ['role_id', $roleId],
                            ['permission_id', $permissionId]
                        ])
                        ->first();

    if (!isset($checkPermission) && $returnType == 'redirect') return abort(403);
    if (!isset($checkPermission) && $returnType == 'boolean') return false;

    return true;
}

?>