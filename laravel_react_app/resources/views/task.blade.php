<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <style>
            .task{
                /* width: 500px;
                height: 100px;
                border: solid 5px #000;
                border-color: #000 transparent transparent transparent;
                border-radius: 50%/100px 100px 0 0; */
                background: #24c1c1;
                color: #fff;
                text-align:center;
                width: 100%;
                height: 99px;
                border: solid 3px #f8f7f7;
                /* border-color: #f8f7f7 #f8f7f7 #17161600 #1d1c1c00; */
                border-radius: 0 0 50% 50%;
            }
            .task h3{
                line-height: 50px;
                font-size: 26px;
            }
            .body-head div{
                font-weight: bold;
                text-align: center;
                color: #24c1c1;
                font-size: 20px;
                margin-top: 20px;
            }
            .body-head span{
                margin-left: 50px;
                background: #23c1c1;
                padding: 0 5px;
                border-radius: 50%;
                color: #fff;
                cursor: pointer;
            }
            a:hover {
                text-decoration: none;
            }
            .card-list{

                margin-top: 20px;
            }

            .card-list .row{
                padding: 10px;
            }
            .card-list .options:hover{
                display: block;
            }
            .card-list .card{
                padding: 0px;
                width: 40%;
                background: #fff;
                margin-left: 30%;
                border FONT-WEIGHT: 200;
                margin-bottom: 6px;
                /* border-bottom: solid 5px #e05e5e;
                */
                border-radius: 5px;
            }
            .color-div{
                border-radius: 0 0 5px 5px;
                height: 6px;
                border-radius: 0 0 5px 5px;

            }
        </style>
    </head>
    <body style="background: #eceaea59; padding:0">
        <div class="row task">
            <h3 style=" ">TASKS</h3>
        </div>
        <div class="row body-head">
            <div>
                Example List
                <span data-toggle="modal" data-target="#myModal">+
                </span>
            </div>
        </div>

        <div class="row card-list">
            @if($tasks)
            @foreach ($tasks as $task)
            @php
            $color = '';
            if($task->priority == 'low' ){
                $color = 'background-color:green';
            } else if($task->priority == 'medium' ){
                $color = 'background-color:yellow';
            } else if($task->priority == 'testing' ){
                $color = 'background-color:yellow';
            } else if($task->priority == 'high' ){
                $color = 'background-color:red';
            }
            @endphp
            <div>
                <div class="card">
                    <div class="row">
                        <div class="col-md-10 showed-values">
                            {{$task->due_date}}<br>
                            <b>{{$task->task}}</b>
                        </div>
                        <div class="col-md-2 options">
                            <a> <i class="fas fa-edit" onclick="editTask(this,{{$task->id}})"></i></a>
                            <a> <i class="fas fa-trash" onclick="deleteTask(this,{{$task->id}})"></i></a>
                        </div>
                    </div>
                    <div class="color-div" style="{{$color}}"></div>
                </div>
            </div>
            @endforeach
            @endif

        </div>

    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create Task
          </h4>
        </div>
        <div class="modal-body">
          <p>Task</p>
          <input class="form-control" name="task" id="task">
          <p>Due Date</p>
          <input name="due_date" type="datetime-local" class="form-control" id="due-date">
          <p>Priority</p>
          <select class="form-control" name="priority" id="priority">
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="testing">Testing</option>
              <option value="high">High</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" onclick="savetask();">Add</button>
        </div>
      </div>
    </div>
  </div>

  <!-- edit Modal -->
  <button data-toggle="modal" id="editModalbtn" style="display:none;" data-target="#editModal"></button>
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Task
          </h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" onclick="updateTask();">Edit</button>
        </div>
      </div>
    </div>
  </div>

  <script>

      function savetask(){

        $.ajax({

            url : "{{url('task/save')}}/",
            method: 'POST',
            data : {
                _token:"{{ csrf_token()}}",
                task: $('#myModal').find('#task').val(),
                due_date: $('#myModal').find('#due-date').val(),
                priority: $('#myModal').find('#priority').val(),
            },

            success: function (response) {
                if(response.status){
                    $('.card-list').append(response.task);

                }
            },
            complete: function(response){
                $('#myModal').find('.close').trigger('click');
            }
        })
      }
      var THIS;
       function editTask(ds,id){
        THIS = ds;
            $.ajax({

                url : "{{url('task/edit/')}}/"+id,
                method: 'get',

                success: function (response) {
                    if(response.status){
                        $('#editModal').find('.modal-body').html('');
                        $('#editModal').find('.modal-body').html(response.task);
                        $('#editModalbtn').trigger('click');
                    }
                }
            });
        }

        function updateTask(){
            var id =  $('#editModal').find('#task-id').val();
            $.ajax({
                url : "{{url('task/update')}}/"+id,
                method: 'POST',
                data : {
                    _token:"{{ csrf_token()}}",
                    task: $('#editModal').find('#task').val(),
                    due_date: $('#editModal').find('#due-date').val(),
                    priority: $('#editModal').find('#priority').val(),
                },

                success: function (response) {
                    if(response.status){
                        $html = $('#editModal').find('#due-date').val()+'<br>'+$('#editModal').find('#task').val();
                        $(THIS).parent().parent().prev().html($html);
                        $(THIS).parent().parent().parent().next().css('background',response.color);

                        $('.card-list').append(response.task);
                    }
                },
                complete: function(response){
                    $('#editModal').find('.close').trigger('click');
                }
            })
        }

        function deleteTask(ds,id){
            $.ajax({
                url : "{{url('task/delete/')}}/"+id,
                method: 'get',

                success: function (response) {
                    if(response.status){
                        $(ds).parent().parent().parent().parent().parent().remove();
                    }
                }
            });
        }
  </script>

    </body>
</html>
