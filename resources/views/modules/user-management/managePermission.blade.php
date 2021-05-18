@extends('layouts.admin')

@section('title', 'Manage Permission')

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">

              @if (Session::get('status-title'))
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-blue text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <circle cx="12" cy="12" r="9"></circle>
                              <line x1="12" y1="8" x2="12.01" y2="8"></line>
                              <polyline points="11 12 12 12 12 16 13 16"></polyline>
                            </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                              {{ Session::get('status-title') }}
                            </div>
                            <div class="text-muted">
                              {{ Session::get('status-subtitle') }}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
              @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Permission</h3>
                    </div>
                    <ul class="nav nav-tabs" data-bs-toggle="tabs">
                        <?php $index = 0 ?>
                        @foreach($role as $rl)
                            <?php
                                $activeClass = '';
                                $isFirstIndex = $index == 0;
                                if ($isFirstIndex) $activeClass = 'active';
                            ?>

                            <li class="nav-item">
                                <a href="#permission-setting" onclick="permission.getActiveTabPermission()" class="nav-link role-tab {{ $activeClass }}" role-id="{{ $rl->id }}" data-bs-toggle="tab">{{ $rl->name }}</a>
                            </li>
                            <?php $index++; ?>
                        @endforeach
                    </ul>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="permission-setting">
                                <div>
                                    <div class="text-muted loading" style="font-style:italic;font-weight:bold;display:none;">
                                        <table>
                                            <tr>
                                                <td><div class="spinner-border text-primary loading-spinner" role="status"></div></td>
                                                <td style="padding-left:10px;"><div class="loading-text"></div></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br/>

                                    <h4>Topic</h4>
                                    <ul>
                                        <table style="width:100%;">
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px;width:80%">
                                                    <li>Create new topic</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(1)" type="checkbox" permission-id="1" />
                                                </td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px">
                                                    <li>View topic list</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(2)" type="checkbox" permission-id="2"/>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px">
                                                    <li>Update topic setting</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(3)" type="checkbox" permission-id="3"/>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px">
                                                    <li>Update topic content (incl. topic version, docs breakdown and post)</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(4)" type="checkbox" permission-id="4"/>
                                                </td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px">
                                                    <li>Delete topic</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(5)" type="checkbox" permission-id="5"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </ul>
                                    <h4>User</h4>
                                    <ul>
                                        <table style="width:100%;">
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px;width:80%">
                                                    <li>View user list</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(6)" type="checkbox" permission-id="6" />
                                                </td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px">
                                                    <li>Create new user</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(7)" type="checkbox" permission-id="7" />
                                                </td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px">
                                                    <li>Update user</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(8)" type="checkbox" permission-id="8" />
                                                </td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px">
                                                    <li>Delete user</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(9)" type="checkbox" permission-id="9" />
                                                </td>
                                            </tr>
                                        </table>
                                    </ul>
                                    <h4>Permission Settings</h4>
                                    <ul>
                                        <table style="width:100%;">
                                            <tr style="border-bottom:1px solid #E2E3E6;">
                                                <td style="padding-right:20px;padding:5px 8px;width:80%">
                                                    <li>Manage permission</li>
                                                </td>
                                                <td>
                                                    <input onchange="changePermission(10)" type="checkbox" permission-id="10" />
                                                </td>
                                            </tr>
                                        </table>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
        </div>
    </div>
@endsection

@section('js')
<script>
var permission = {
    showLoading: function (loadingText) {
        $('.loading-text').text(loadingText);
        $('.loading-spinner').show();
        $('.loading').show();
    },
    afterLoadingMsg: function (msg) {
        setTimeout(function () {
            $('.loading-text').text(msg);
            $('.loading-spinner').hide();
        }, 500);
    },
    getActiveTab: function() {
        var activeRoleTab = 0;
        $('.role-tab').each(
            function (index) {
                var isActive = $(this).hasClass('active');
                if (isActive) {
                    var currentRoleTab = $(this).attr('role-id');
                    activeRoleTab = currentRoleTab;
                }
            }
        )

        return activeRoleTab;
    },
    getActiveTabPermission: function () {
        var activeTab = permission.getActiveTab();

        $.ajax({
            url: "{{ url('/admin/user-management/permission') }}/" + activeTab,
            method: "GET",
            beforeSend: function (xhr) {
                permission.showLoading('LOADING ...');
            },
            success: function (res) {
                permission.afterLoadingMsg('');

                // uncheck permission
                var permissionTotalNumber = 10;
                for (i=0;i < permissionTotalNumber; i++) {
                    var currElementId = i + 1;
                    $('input[permission-id='+ currElementId +']').prop('checked', false);
                }

                for (i=0;i < res.length; i++) {
                    // set current permission to checked
                    var currElement = res[i];
                    var currElementId = currElement.permission_id;
                    
                    $('input[permission-id='+ currElementId +']').prop('checked', true);
                }
            },
            error: function (err) {
                permission.afterLoadingMsg('ERROR! SOMETHING WENT WRONG');
            }
        })
    }
}

function changePermission(checkboxId) {
    var roleId = permission.getActiveTab();
    var value = $('input[permission-id=' + checkboxId + ']:checkbox:checked').length > 0;

    $.ajax({
        url: '{{ url("admin/user-management/permission") }}',
        method: 'POST',
        data: {
            '_token': '{{ csrf_token() }}',
            'permission_id': checkboxId,
            'role_id': roleId,
            'action': value ? 1 : 0
        },
        beforeSend: function (xhr) {
            permission.showLoading('SAVING ...');
        },
        success: function (res) {
            permission.afterLoadingMsg('CHANGE SAVED');
        },
        error: function (err) {
            permission.afterLoadingMsg('ERROR! SOMETHING WENT WRONG');
        }
    })
}

$(function () {
    permission.getActiveTabPermission();
})
</script>
@endsection