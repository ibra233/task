@extends('thema')

@section('body')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">{{ __('view.header-employee') }}</h4>
          
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
                
              <div class="d-flex justify-content-end ">  <button type="button" class="btn btn-primary btn-lg  me-4 mb-2" data-bs-toggle="modal" data-bs-target="#employee-add-modal">
                {{ __('view.add-employee') }}
              </button></div>
            
              <div class="table-responsive">
                <table
                  id="zero_config"
                  class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>{{ __('view.name-employee') }}</th>
                      <th>{{ __('view.company-employee') }}</th>
                      <th>{{ __('view.processing') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>{{ __('view.name-employee') }}</th>
                      <th>{{ __('view.company-employee') }}</th>
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
<div class="modal fade" id="employee-add-modal" tabindex="-1" aria-labelledby="industry-add-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('view.header-employee') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="update-form" onsubmit="employeeAdd(event)">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">{{ __('view.name-employee') }}</label>
              <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="row g-3" id="industries">
              <div class="col-11">
                <label for="text" class="form-label">{{ __('view.company-employee') }}</label>
              <select class="form-select" name="company_id" aria-label="Default select example">
                <option value="" selected>{{ __('view.select') }}</option>
                @isset($companies)
                  @foreach ($companies as $company)
                  <option value={{$company->id}}>{{$company->name}}</option>
                  @endforeach
                @endisset
              </select>
              </div>
              
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
 <div class="modal fade" id="employee-update-modal" tabindex="-1" aria-labelledby="industry-add-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('view.header-employee') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="PUT" id="update-form" onsubmit="updateEmployee(event)">
            @csrf

            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">{{ __('view.name-employee') }}</label>
              <input type="text" name="name"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div> 
            
            
            <div class="row g-3" id="industries">
              <div class="col-11">
                <label for="text" class="form-label">{{ __('view.company-employee') }} </label>
              <select class="form-select" name="company_id" aria-label="Default select example">
                <option value="" selected>{{ __('view.select') }}</option>
                @isset($companies)
                  @foreach ($companies as $company)
                  <option value={{$company->id}}>{{$company->name}}</option>
                  @endforeach
                @endisset
              </select>
              </div>
              
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
    responsive: true,
    autoWidth: true,
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    @if (App::isLocale('tr')) 
    language: {
              url: "./dist/js/tr.json"
                },
    @endif
    ajax: {
        url: '{{route('employee.index')}}',
        method: 'GET'
    },
    columns: [
      { data: 'id' },
      { data: 'name' },
      { data: 'company' },
      {data : 'id'}
        ],
    columnDefs:[
      { "width": "20%", "targets": 3 },
      {
        render: function(data, type, row){
          return `<p id="${data.id}">${data.name} </p>`;
        },
        targets: 2,
       
      },
      {
        render: function(data, type, row){
          return `<button onclick="updateModalEmployee(this,${data})" type="button" class="btn btn-warning">
            {{ __('view.edit') }}
                    </button> <button  onclick="deleteEmployee(${data})" type="button" class="btn btn-danger ml-3">
                      {{ __('view.delete') }}
                    </button> `
        },
        targets: 3,
       
      }
    ]
  });



 
</script>
<script src="./dist/js/employee.js" ></script>
@endsection