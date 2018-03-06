@extends('layouts.list')

@section('index-content')
   <table id="datatable" class="table table-striped table-bordered" cellspacing="0">
      <thead>
         <tr>
            <th>name</th>
            <th>email</th>
         </tr>
      </thead>
   </table>
@endsection

@section('scripts')
   <script src="DataTables/datatables.min.js"></script>
   <script src="/js/users.js"></script>
@endsection
