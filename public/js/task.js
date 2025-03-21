//task add function
$(document).ready(function () {
    $('#addTaskForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "/tasks", 
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                title: $('#title').val(),
                description: $('#description').val(),
                due_date: $('#due_date').val(),
            },
            success: function (response) {
                $('#addTaskModal').modal('hide'); 
                location.reload(); 
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                alert('Error adding task: ' + JSON.stringify(errors));
            }
        });
    });
});


$(document).ready(function () {
   
    $("body").on("click", ".editTaskBtn", function () {
        let taskId = $(this).data("id");

        $.ajax({
            url: `/tasks/${taskId}/edit`,
            type: "GET",
            success: function (response) {
                if (response.task) {
                    $("#editTaskId").val(response.task.id);
                    $("#editTitle").val(response.task.title);
                    $("#editDescription").val(response.task.description);
                    $("#editDueDate").val(response.task.due_date);
                    
                    $("#editTaskModal").modal("show"); 
                } else {
                    alert("Task data not found!");
                }
            },
            error: function (xhr) {
                console.log("Error fetching task:", xhr.responseText);
                alert("Failed to fetch task details.");
            }
        });
    });

    // Update Task via AJAX
    $("#editTaskForm").submit(function (e) {
        e.preventDefault();
        let taskId = $("#editTaskId").val();

        $.ajax({
            url: `/tasks/${taskId}`,
            type: "PUT",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                title: $("#editTitle").val(),
                description: $("#editDescription").val(),
                due_date: $("#editDueDate").val(),
            },
            success: function (response) {
                $("#editTaskModal").modal("hide"); 
                location.reload(); 
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                alert("Error updating task: " + JSON.stringify(errors));
            }
        });
    });
});


//Delete btn triger
$(document).ready(function () {
   
    $(document).on('click', '.deleteTaskBtn', function () {
        var taskId = $(this).data('id');
        deleteTask(taskId);
    });
});

    // Function to delete task
    function deleteTask(taskId) {
        if (!confirm('Are you sure you want to delete this task?')) return;
        
        $.ajax({
            url: `/tasks/${taskId}`,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                alert(response.message); 
                location.reload(); 
            },
            error: function (xhr) {
                alert("Error deleting task: " + xhr.responseText);
            }
        });
    }
    
   //Task Status function
    $(document).ready(function () {
       
        $(document).on('click', '.taskStatus', function (e) {
            e.stopPropagation(); 
            var taskId = $(this).data('id');
            var currentStatus = $(this).text().trim();
    
            var dropdown = `
                <select class="statusDropdown form-select" data-id="${taskId}">
                    <option value="Pending" ${currentStatus === "Pending" ? "selected" : ""}>Pending</option>
                    <option value="Completed" ${currentStatus === "Completed" ? "selected" : ""}>Completed</option>
                </select>
            `;
    
            $(this).html(dropdown);
            $('.statusDropdown').focus(); 
        });
    
       
        $(document).on('click', '.statusDropdown', function (e) {
            e.stopPropagation(); 
        });
    
        
        $(document).on('change', '.statusDropdown', function () {
            var taskId = $(this).data('id');
            var newStatus = $(this).val();
            var button = $(this).parent();
    
            $.ajax({
                url: `/tasks/${taskId}/toggle-status`,
                type: 'PATCH',
                data: { status: newStatus },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    button.html(response.status)
                        .removeClass('btn-warning btn-success')
                        .addClass(response.status === 'Completed' ? 'btn-success' : 'btn-warning');
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    alert('Failed to update task status.');
                }
            });
        });
    
        // Ensure dropdown remains function
        $(document).on('blur', '.statusDropdown', function () {
            var selectedStatus = $(this).val();
            var taskId = $(this).data('id');
            $(this).parent().html(selectedStatus)
                .removeClass('btn-warning btn-success')
                .addClass(selectedStatus === 'Completed' ? 'btn-success' : 'btn-warning');
        });
    });
    
    

    // Attach event listeners
    $(document).on('click', '.editTaskBtn', function () {
        var taskId = $(this).data('id');
        openEditTaskModal(taskId);
    });

    $('#editTaskForm').submit(updateTask);

    $(document).on('click', '.deleteTaskBtn', function () {
        var taskId = $(this).data('id');
        deleteTask(taskId);
    });

    $(document).on('click', '.toggleStatusBtn', function () {
        var taskId = $(this).data('id');
        toggleTaskStatus(taskId);
    });
