<?php

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

?>