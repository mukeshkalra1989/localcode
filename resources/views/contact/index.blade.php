@extends('layouts.app')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<!-- Include DataTables Buttons CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<!-- Include PDFMake library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>




@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Contacts') }}</div>

                <div class="card-body">
                    <!-- Import Contact via CSV -->
                    <form action="{{ route('uploadcsv') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="file">Choose CSV File:</label>
                        <input type="file" name="file" id="file">
                        <button type="submit">Upload</button>
                    </form>
                    
                    <button onclick="window.location='{{ route('contact.create') }}'" type="button">
                        Add new contact
                    </button>

                    
                
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>
                                  Name of contact
                                  <input type="text" name="searchContactname" class="form-control searchContactname" placeholder="Search for Contact name Only...">                                  
                                </th>
                                <th>
                                  Phone number
                                  <input type="text" name="phono_number" class="form-control searchPhone" placeholder="Search for Phone number Only...">
                                </th>
                                <th>
                                  Email
                                  <input type="email" name="email" class="form-control searchEmail" placeholder="Search for Email Only...">
                                </th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>

                
                
            </div>
        </div>
    </div>
</div>

<!-- Your DataTable Initialization Script -->
<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('contact.index') }}",
        data: function (d) {
          d.email = $('.searchEmail').val();
          d.search = $('input[type="search"]').val();
          d.phone = $('.searchPhone').val();
          d.contact_name = $('.searchContactname').val();
          
        }
      },
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'name', name: 'name'},
        {data: 'phone_number', name: 'phone_number'},
        {data: 'email', name: 'email'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
      dom: 'Bfrtip', // Add Buttons extension to the DOM
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print' // Include the buttons you need
      ]
    });

    // Filter for email
    $(".searchEmail").keyup(function(){
        table.draw();
    });
    
    // Filter for Phne number
    $(".searchPhone").keyup(function(){
        table.draw();
    });

    // Filter for contact name
    $(".searchContactname").keyup(function(){
        table.draw();
    });
    
  });
</script>
@endsection

