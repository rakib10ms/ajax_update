@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-header">
    <div id="success"> </div>
    <div id="succ"> </div>
    <h4> Student data </h4>
    <a href="" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#addStudent"> Add Student</a>
    <a  class="btn btn-success float-start" > Total: <span class="spann"> </span> </a> 
   </div>

  <div class="card-body">
    <table class="table table-bordered">
    <thead>
      <tr>
      <th> ID</th>
      <th> Name</th>
      <th> Email</th>
      <th> Phone</th>
      <th> Course</th>
      <th> Edit</th>
      <th> Delete</th>
     </tr>
    </thead>  
      <tbody>
        
        
      </tbody>
    </table>


<!--delete modal -->

<!-- Modal -->
<div class="modal fade" id="deleteStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     <input type="hidden" id='del_id'/> 
      <h4>Are you want to sure ? </h4>

      
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_student_btn">Save</button>
      </div>
    </div>
  </div>
</div>






<!--edit and update modal-->

<div class="modal fade" id="editStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <ul id="updateform_errList"> </ul>
        <input type="hidden" id="editFormId" />
        <div class="form-group mb-3">
          <label> Student Name </label>
          <input type="text" class="name form-control" id="edit_name"/>

        </div>

        <div class="form-group mb-3">
          <label> Student Email </label>
          <input type="text" class="email form-control"  id="edit_email"/>

        </div>

        <div class="form-group mb-3">
          <label> Student Phone</label>
          <input type="text" class=" phone form-control"  id="edit_phone"/>

        </div>

        <div class="form-group mb-3">
          <label>  Course Name</label>
          <input type="text" class=" course form-control"  id="edit_course"/>

        </div>

      
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_student">Save</button>
      </div>
    </div>
  </div>
</div>










  <!--add student modal -->

<!-- Modal -->
<div class="modal fade" id="addStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <ul class="" id="saveform_errList"> </ul>
        <div class="form-group mb-3">
          <label> Student Name </label>
          <input type="text" class="name form-control" class="name"/>

        </div>

        <div class="form-group mb-3">
          <label> Student Email </label>
          <input type="text" class="email form-control" class="email"/>

        </div>

        <div class="form-group mb-3">
          <label> Student Phone</label>
          <input type="text" class=" phone form-control" class="phone"/>

        </div>

        <div class="form-group mb-3">
          <label>  Course Name</label>
          <input type="text" class=" course form-control" class="course"/>

        </div>

      
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_student">Save</button>
      </div>
    </div>
  </div>
</div>

  </div>
</div>
@endsection




@section('scripts')
<script>

//fetch all data ajax

$(document).ready(function(){
  fetchStudent();
  function fetchStudent(){
    $.ajax({
      type:'GET',
      url:'/fetch-students',
      dataType:'json',
      success:function(response){
   
        $('tbody').html('');
        $('.spann').html('');
        $('.spann').append(response.total);
        $.each(response.students,function(key,val){
          $('tbody').append(
          '<tr>\
          <td>'+val.id +' </td>\
          <td>'+val.name +' </td>\
          <td>'+val.email + '</td>\
          <td>'+val.phone +' </td>\
          <td>'+val.course +'</td>\
          <td><button type="button" value="'+val.id+'" class="edit_student btn btn-primary" id="edit">Edit </button> </td>\
          <td><button type="button" value="'+val.id+'" class="delete_student btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStudent">Delete</button> </td>\
        </tr>'
          );
        });
      }
    });
  }




//edit ajax code

$(document).on('click','.edit_student',function (e){
  e.preventDefault();
  var editData=$(this).val();
  $('#editStudent').modal('show');

  $.ajax({
    type:'GET',
    url:'/edit_students/'+editData,
    success:function(response){
      $('#editFormId').val(editData);
      $('#edit_name').val(response.editStudent.name);
      $('#edit_email').val(response.editStudent.email);
      $('#edit_phone').val(response.editStudent.phone);
      $('#edit_course').val(response.editStudent.course);
    }
  });
 
})


//update ajax code


$(document).on('click','.update_student',function (e){
  e.preventDefault();
  var updateVal=$('#editFormId').val();
  
  var updateData={
    'name':$('#edit_name').val(),
    'email':$('#edit_email').val(),
    'phone':$('#edit_phone').val(),
    'course':$('#edit_course').val(),
  }

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    type:'POST',
    url:'/update_students/' +updateVal,
    data:updateData,
    dataType:'json',
    success:function(response){
      if(response.status==400){
        $('#updateform_errList').html('');
        $('#updateform_errList').addClass('alert alert-danger');
        $.each(response.errors,function(key,err_values){
          $('#updateform_errList').append('<li>' +err_values+  '</li>');
        });
      }
      else{
      $('#updateform_errList').html('');
        $('#success').addClass('alert alert-success');
        $('#success').text(response.message);
        $('#editStudent').modal('hide');
        $('#editStudent').find('input').val('');
        fetchStudent();

      }
    },
  
    
});

  

});





//add ajax code

$(document).on('click','.add_student',function(e){
  e.preventDefault();

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

  var data={
    name:$('.name').val(),
    email:$('.email').val(),
    phone:$('.phone').val(),
    course:$('.course').val(),
  }

  $.ajax({
    type:'POST',
    url:'/students',
    data:data,
    dataType:'json',
    success:function(response){
      if(response.status==400){
        $('#saveform_errList').html('');
        $('#saveform_errList').addClass('alert alert-danger');
        $.each(response.errors,function(key,err_values){
          $('#saveform_errList').append('<li>' +err_values+  '</li>');
        });
      }
      else{
      $('#saveform_errList').html('');
        $('.succ').addClass('alert alert-success');
        $('.succ').text(response.message);
        $('#addStudent').modal('hide');
        $('#addStudent').find('input').val('');
        fetchStudent();

      }
    }
    
  });
});





//delete ajax query


  $(document).on('click','.delete_student',function(e){
    e.preventDefault();
    var id=$(this).val();
     $('#del_id').val(id);

  });


  $(document).on('click','.delete_student_btn',function(e){
    e.preventDefault();
    var stu_id=$('#del_id').val();

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    type:'GET',
    url:'/delete_students/'+stu_id,
    dataType: 'json', 
    success:function(response){
     if(response.status==200){
      $('#deleteStudent').modal('hide');
      $('#success').addClass('alert alert-success');
      $('#success').text(response.message);

      fetchStudent();
     }
    }

  });

});
});


//total count ajax




  </script>

@endsection