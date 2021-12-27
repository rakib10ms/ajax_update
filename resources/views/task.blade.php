@extends('layouts.app')
@section('content')
<div class="card my-3">
  <div class="card-header d-flex justify-content-between ">
<h3> Create Task </h3>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTask"> Create Task </button>
  </div>

<!-- Create Modal -->
<div class="modal fade" id="createTask" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul id="addError"> </ul>
        <form id="createBtn">
          <div class="form-group mb-3">
            <label for="exampleInputEmail1">Task Name</label>
            <input type="text" class="form-control"  aria-describedby="emailHelp" id="name" name="name" value="">
          </div>
          <div class="form-group mb-3">
            <label for="exampleInputEmail1">Task type</label>
            <input type="text" class="form-control"  aria-describedby="emailHelp" id="type" name="type" value="">
          </div>

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="">Create Task</button>
      </div>
    </form>
    </div>
  </div>
</div>



  <div class="card-body">
    <h3 id="success"></h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody id="table">
       
     
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function(){
    $(document).on('submit','#createBtn',function(e){
      e.preventDefault();
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

      var data={
        name:$('#name').val(),
        type:$('#type').val(),
      }

      $.ajax({
        type:'POST',
        url:'/addTask',
        data:data,
        dataType:'json',
        success:function(response){
            if(response.status==200){
              $('#success').html('');
              $('#success').text(response.message);
              $('#success').addClass('alert alert-success');
              $('#createTask').modal('hide');
              $('#createBtn').find('input').val('');
              fetchStudent();
              
            }
            else{
              $('#addError').html();
              $('#addError').addClass('alert alert-danger');
              $.each(response.errors,function(key,value){
                $('#addError').append('<li>' +value+ '</li>');
              });
            }
        },
        error:function(response){
          console.log('eror');
        }

      });

    });

  //read ajax

  function fetchStudent(){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
      $.ajax({
        type:'GET',
        url:'/allTask',
        dataType:'json',
        success:function(response){
          $('#table').html('');
           $.each(response.all,function(key,val){

             $('#table').append('val');
           }); 
             
              
            
        },
        error:function(response){
          console.log('eror');
        }

      }); 
   
       
    }
    










  });
</script>
@endsection