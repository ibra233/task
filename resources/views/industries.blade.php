@extends('thema')

@section('body')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">{{ __('view.header-industry') }}</h4>
          
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
      <!-- ============================================================== -->
      <!-- Start Page Content -->
      <!-- ============================================================== -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
                
              <div class="d-flex justify-content-end ">  <button type="button" class="btn btn-primary btn-lg  me-4 mb-2" data-bs-toggle="modal" data-bs-target="#industry-add-modal">
                {{ __('view.add-industry') }}
              </button></div>
            
              <div class="table-responsive">
                <table
                  id="zero_config"
                  class="table table-striped table-bordered"
                >
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>{{ __('view.name-industry') }}</th>
                      <th>{{ __('view.processing') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    

             
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>{{ __('view.name-industry') }}</th>
                      <th>{{ __('view.processing') }}</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- End PAge Content -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Right sidebar -->
      <!-- ============================================================== -->
      <!-- .right-sidebar -->
      <!-- ============================================================== -->
      <!-- End Right sidebar -->
      <!-- ============================================================== -->
    </div>
   <!--  Start Add Modal -->
<div class="modal fade" id="industry-add-modal" tabindex="-1" aria-labelledby="industry-add-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('view.add-industry') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="update-form" onsubmit="industryAdd(event)">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">{{ __('view.name-industry') }}</label>
              <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
              
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('view.close') }}</button>
        <button type="submit"  class="btn btn-primary">{{ __('view.add') }}</button>
    </div>
    </form>
    </div>
  </div>
</div>
 <!--  End Add Modal -->

 <!--  Start Update Modal -->
 <div class="modal fade" id="industry-update-modal" tabindex="-1" aria-labelledby="industry-add-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('view.update-industry') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="PUT" id="update-form" onsubmit="updateIndustry(event)">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">{{ __('view.name-industry') }}</label>
              <input type="text" name="name"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
              
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('view.close') }}</button>
        <button type="submit"  class="btn btn-primary">{{ __('view.update') }}</button>
    </div>
    </form>
    </div>
  </div>
</div>
 <!--  End Update Modal -->
@endsection

@section('script')
<script>
  /****************************************
   *       Basic Table                   *
   ****************************************/

   var dataTable = $("#zero_config").DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    @if (App::isLocale('tr')) 
    language: {
              url: "./dist/js/tr.json"
                },
    @endif
    
    ajax: {
        url: '{{route('industry.index')}}',
        method: 'GET'
    },
    columns: [
      { data: 'id' },
      { data: 'name' },
      {data : 'id'}
        ],
    columnDefs:[
      { "width": "20%", "targets": 2 },
      {
        render: function(data, type, row){
          return `<button onclick="updateModalIndustry(this,${data})" type="button" class="btn btn-warning">
            {{ __('view.edit') }}
                    </button> <button  onclick="deleteIndustry(${data})" type="button" class="btn btn-danger ml-3">
                      {{ __('view.delete') }}
                    </button> `
        },
        targets: 2,
        width: "%20"
      }
    ]
  });



 
</script>
<script src="./dist/js/industry.js" ></script>
@endsection