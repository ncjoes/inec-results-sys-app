$(function () {

    /********************
     *     Constants    *
     ********************/
    const listItemTransparency = 0.95;

    const colors = {
        pending: 'rgba(255,255,255,' + listItemTransparency + ')',
        progress: 'rgba(255,255,170,' + listItemTransparency + ')',
        completed: 'rgba(212,255,170,' + listItemTransparency + ')',
    };
    /********************
     *     Functions    *
     ********************/

    /**
     * Save the ordering of the task list into local storage
     */
    var saveTaskListOrder = function () {
        var tableRows = $('#sortableTodo');
        var taskListOrder = tableRows.sortable('toArray');
        localStorage.setItem('taskList', JSON.stringify(taskListOrder));

        // Saving task-priorities to database
        window.ajaxCall({
            url: '/update-task-priorities',
            method: 'POST',
            dataType: 'json',
            data: {taskListOrder: taskListOrder},
            onSuccess: function (response) {
                console.log(response);
            }
        });
    };

    /**
     * Get a color String depending on the task state
     * @param status - String
     * @return String
     */
    var getColorOfState = function (status) {
        if (status === 'Pending') {
            return colors.pending;
        } else if (status === 'Progress') {
            return colors.progress;
        } else if (status === 'completed') {
            return colors.completed;
        }
        throw 'State ' + status + ' not handled.';
    };

    /**
     * Creates an HTML element from a TaskListItem
     * @param taskListItem - TaskListItem
     * @return HTML element
     */
    var generateElement = function (taskListItem) {
        return $(
            "<tr data-role='list-divider' id='" + taskListItem.id + "' style='background-color: " + getColorOfState(taskListItem.status) + "'>" +
            "<td><b>" + taskListItem.taskName + "</b></td>" +
            "<td>" + taskListItem.project.name + "</td>" +
            "<td>" + taskListItem.creationDate + "</td>" +
            "<td><a class='btn btn-default' href='update-task/" + taskListItem.id + "'>edit</a> <button class='task-delete-btn btn btn-danger' data-id='" + taskListItem.id + "'>delete</button></td>" +
            "</tr>"
        );
    };

    /**
     * Adds a TaskListItem to the current page
     * @param taskListItem - TaskListItem
     */
    var addTaskToDisplay = function (taskListItem) {
        var elem = generateElement(taskListItem);
        var listName = '#sortableTodo';
        $(listName).append(elem);
    }



    /********************
     *  Initialization  *
     ********************/

    var taskList = JSON.parse(localStorage.getItem('taskList'));
    taskList = taskList || {};

    $('a').each(function () {
        var anchor = $(this);
        if (anchor.attr('href') === window.currentUrl) {
            anchor.addClass('active');
            anchor.parent('li').addClass('active');
        }
    });

    /* Set up the sortable lists */
    $('#sortableTodo').sortable({
        cancel: 'span',
        update: function (event, ui) {
            saveTaskListOrder();
        }
    });

    /* Allow hitting enter while typing to add a task*/
    $('#task-name').keyup(function (event) {
        if (event.keyCode == 13) {
            $('#addTaskForm').submit();
        }
    });

    /* Saving task to database */
    $('#addTaskForm').submit(function (e) {
        e.preventDefault();
        var form = $(this);

        window.submitAjaxForm({
            onSuccess: function (taskItem) {
                taskList[taskItem.id] = taskItem;
                localStorage.setItem('taskList', JSON.stringify(taskList));

                addTaskToDisplay(taskItem);

                $('#task-name').val('');
            }
        }, form);
    });

    $('.task-delete-btn').click(function (e){
        var btn = $(this);

        window.ajaxCall({
            url: '/delete-task',
            method: 'DELETE',
            dataType: 'json',
            data: {taskId: [btn.data('id')]}
        });
    });

    $('.project-delete-btn').click(function (e){
        var btn = $(this);

        window.ajaxCall({
            url: '/delete-project',
            method: 'DELETE',
            dataType: 'json',
            data: {projectId: [btn.data('id')]}
        });
    });
});
