@extends('layouts.admin')

@section('title', 'Documentation')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<style>
.dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
  padding: 20px !important;
}

select[name=DataTables_Table_0_length] {
  margin-right: 5px !important;
  margin-left: 5px !important;
}

#DataTables_Table_0_filter > label > input {
  margin-right: 5px !important;
  margin-left: 5px !important;
}

table.dataTable.no-footer, table.dataTable thead th, table.dataTable thead td {
  border-bottom-color: rgb(226, 227, 230) !important;
}

.paginate_button, .current  {
  background: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  color: black !important;
  font-weight: bold !important;
}
</style>
@endsection

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-12">

              <div class="card card-sm javascript-msg" style="display:none">
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
                          <div class="font-weight-medium javascript-msg-title"></div>
                          <div class="text-muted javascript-msg-subtitle"></div>
                      </div>
                      </div>
                  </div>
              </div>

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

              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Topic List</h3>
                  </div>
                  <div class="table-responsive">
                    <a href="{{ url('/admin/documentation/new-topic') }}" style="margin:20px;" class="btn btn-primary btn-md">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="12" r="9"></circle>
                        <line x1="9" y1="12" x2="15" y2="12"></line>
                        <line x1="12" y1="9" x2="12" y2="15"></line>
                      </svg>
                      Create new topic
                    </a>
                    
                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th class="w-1"></th>
                          <th>Topic Name</th>
                          <th>Created By</th>
                          <th>Last Update</th>
                          <th>Date Created</th>
                          <th>Assignees</th>
                          <th></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="confirm-delete-prompt" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-danger"></div>
          <div class="modal-body text-center py-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
            <h3 class="confirm-delete-title"></h3>
            <div class="text-muted" id="confirm-delete-prompt-text"></div>
          </div>
          <div class="modal-footer confirm-delete-footer">
            <div class="w-100">
              <div class="row">
                <div class="col">
                  <a href="#" class="btn btn-white w-100" data-dismiss="modal">
                    Cancel
                  </a>
                </div>
                <div class="col">
                  <a href="#" class="btn btn-danger w-100 delete-confirm-btn-delete" data-dismiss="modal">
                    Delete
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
var topicListTable = $('.datatable').DataTable({
  "ajax": "{{ url('api/datatable/topic-list') }}",
  "columns": [
      { "data": "topic_id" },
      { "data": "topic_name" },
      { "data": "topic_created_by" },
      { "data": "topic_last_update" },
      { "data": "topic_date_created" },
      { "data": "topic_assignees" },
      { "data": "action_btn" }
  ]
});

topicListTable.on( 'order.dt search.dt', function () {
    topicListTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    } );
} ).draw();

function deleteConfirm(id, name) {
  @if ($delete_topic_permission)
    $('.confirm-delete-footer').show();
    $('.confirm-delete-title').text('Are you sure?');
    $('#confirm-delete-prompt-text').text('Do you really want to remove ' + name + '? Once deleted, data cannot be restored');
    $('.delete-confirm-btn-delete').attr('onclick', 'deleteTopic('+id+')');
  @else
    $('.confirm-delete-footer').hide();
    $('.confirm-delete-title').text('You are not allowed to delete this');
    $('#confirm-delete-prompt-text').text('Contact your administrator to get access to delete the record');
    $('.delete-confirm-btn-delete').removeAttr('onclick');
  @endif
}

function deleteTopic(id) {
  $.ajax({
    url: '{{ url("/admin/documentation/delete") }}/' + id,
    method: 'POST',
    data: {
      '_token': '{{ csrf_token() }}'
    },
    success: function (res) {
      topicListTable.ajax.reload();
      showMessage('Success', 'Topic deleted');
    },
    error: function (err) {
      console.log('error');
    }
  })
}

function showMessage(title, subtitle) {
  $('.javascript-msg').show();
  $('.javascript-msg-title').text(title);
  $('.javascript-msg-subtitle').text(subtitle);

  setTimeout(function () {
    $('.javascript-msg').hide();
  }, 3000);
}
</script>
@endsection