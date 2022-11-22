@extends('thema')

@section('body')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">{{ __('view.header-company') }}</h4>
          <div class="ms-auto text-end">
           
          </div>
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
                
              <div class="d-flex justify-content-end ">  <button type="button" class="btn btn-primary btn-lg  me-4 mb-2" data-bs-toggle="modal" data-bs-target="#company-add-modal">
                {{ __('view.add-company') }}
              </button></div>
            
              <div class="table-responsive">
                <table
                  id="zero_config"
                  class="table table-striped table-bordered"
                >
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>{{ __('view.name-company') }}</th>
                      <th>Logo </th>
                      <th>{{ __('view.industries') }}</th>
                      <th>{{ __('view.processing') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>{{ __('view.name-company') }}</th>
                      <th>Logo </th>
                      <th>{{ __('view.industries') }}</th>
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
<div class="modal fade" id="company-add-modal" tabindex="-1" aria-labelledby="industry-add-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('view.add-company') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="update-form" onsubmit="companyAdd(event)">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">{{ __('view.name-company') }}</label>
              <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">{{ __('view.logo-company') }}</label>
              <input class="form-control" name="logo" type="file" id="formFile">
            </div>
            
            <div class="row g-3" id="industries">
              <div class="col-11">
                <label for="text" class="form-label">{{ __('view.company-industry') }}</label>
              <select class="form-select" name="company_industry[]" aria-label="Default select example">
                <option value="" selected>{{ __('view.select') }}</option>
                @isset($industries)
                  @foreach ($industries as $industry)
                  <option value={{$industry->id}}>{{$industry->name}}</option>
                  @endforeach
                @endisset
              </select>
              </div>
              
            </div>
            <button type="button" class="btn btn-primary mt-2" onclick="addIndustrySelectBox(this)">{{ __('view.add-industry') }}</button>
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
 <div class="modal fade" id="company-update-modal" tabindex="-1" aria-labelledby="industry-add-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('view.add-company') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="PUT" id="update-form" onsubmit="updateCompany(event)">
            @csrf

            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">{{ __('view.name-company') }}</label>
              <input type="text" name="name"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">{{ __('view.logo-company') }}</label>
              <input class="form-control" name="logo" type="file" id="formFile">
            </div>  
            <div class="mb-3" id="company-industries">
              <p for="formFile" class="form-label">{{ __('view.company-industry') }}</p>
              <div class="d-inline-flex align-items-center p-2 bg-info text-white"> <div class="mw-60">synergize web-enabled technologies</div> <div class="ms-2">
                <a href=""><i class="fas fa-trash ml-2 text-white"></i></a></div> </div>
            </div> 
            
            <div class="row g-3" id="industries">
              <div class="col-11">
                <label for="text" class="form-label">{{ __('view.company-industry') }}</label>
              <select class="form-select" name="company_industry[]" aria-label="Default select example">
                <option value="" selected>{{ __('view.select') }}</option>
                @isset($industries)
                  @foreach ($industries as $industry)
                  <option value={{$industry->id}}>{{$industry->name}}</option>
                  @endforeach
                @endisset
              </select>
              </div>
              
            </div>
            <button type="button" class="btn btn-primary mt-2" onclick="addIndustrySelectBox(this)">{{ __('view.add-industry') }}</button>
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
    @if (App::isLocale('tr')) 
    language: {
              url: "./dist/js/tr.json"
                },
    @endif
    ajax: {
        url: '{{route('company.index')}}',
        method: 'GET'
    },
    columns: [
      { data: 'id' },
      { data: 'name' },
      { data: 'logo' },
      {data: 'get_with_name'},
      {data : 'id'}
        ],
    columnDefs:[
      { "width": "20%", "targets": 4 },
      {
        render: function(data, type, row){
          return   `<img class="img-thumbnail" src='${data}'>`
        },
        targets: 2,
       
      },
      {
        render: function(data, type, row){
          return   Object.values(data).reduce((total,element) =>  total+= `<p id="${element.id}">${element.name} </p>`,'');
        },
        targets: 3,
       
      },
      {
        render: function(data, type, row){
          return `<button onclick="updateModalCompany(this,${data})" type="button" class="btn btn-warning">
            {{ __('view.edit') }}
                    </button> <button  onclick="deleteIndustry(${data})" type="button" class="btn btn-danger ml-3">
                      {{ __('view.delete') }}
                    </button> `
        },
        targets: 4,
       
      }
    ]
  });



 
</script>
<script src="./dist/js/company.js" ></script>
@endsection