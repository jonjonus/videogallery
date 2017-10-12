@extends('layouts.list')

@section('index-content')
   <div class="img-overlay"><img src="/imgs/creativa.png"></div>
   <!-- Current Videos -->
   {{--<table id="datatable" class="table table-hover table-bordered table-condensed">--}}
   <table id="datatable" class="table table-striped table-bordered" cellspacing="0">
      <thead>
         <tr>
            <th>Select</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
         </tr>
      </thead>
   </table>
@endsection

@section('scripts')
   <script src="DataTables/datatables.min.js"></script>
   <script src="/js/users.js"></script>
@endsection
