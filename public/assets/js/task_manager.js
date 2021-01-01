let table;
$(document).ready(function () {
    table = $('#tasks').DataTable({
        "searching": false,
        "pageLength": 3,
        "lengthMenu": [[3, 15, 25, 35, 50, 100], [3, 15, 25, 35, 50, 100]],
        "order": [[0, "desc"]],
        "pagingType": "numbers",
        "processing": true,
        "serverSide": true,
        "ajax": {
            'url': "http://78.47.49.191/getTasks",
            'method': 'POST',
            'headers': {
                'Content-type': 'application/x-www-form-urlencoded'
            },
        },
        "columns": [
            {"data": "id"},
            {
                "data": "name",

            }, {
                "data": "email",

            },
            {
                "data": "status",
                "render": function (data, type, row, meta) {
                    return row['status'] == 1 ? `<span class="badge badge-success">completed</span>` : `<span class="badge badge-success">completed</span> <span class="badge badge-info">edited by admin</span>`;
                }
            },
            {"data": "text"},
            {"data": "created_at"},
            {"data": "updated_at"},
            {
                "data": 'sett',
                "orderable": false,
                "width": "9%",
                "render": function (data, type, row, meta) {
                    return    (window.isLogged) ? `<div class="d-flex">
                                <button class="edit btn btn-dark" data-id='${row["id"]}' data-toggle="modal" data-target="#taskModal">Edit</button>
                            </div>` : '';
                }
            }
        ]
    });

    var constraints = {
        name: {
            presence: true,
            length: {
                minimum: 3
            }
        },
        email: {
            presence: true,
            email: true
        },
        text: {
            presence: true,
            length: {
                minimum: 5
            }
        },
    };

    var form = document.querySelector("form#task");
    form.addEventListener("submit", function (ev) {
        ev.preventDefault();
        handleFormSubmit(form);
    });

    var inputs = document.querySelectorAll("#task input,#task textarea,#task select")
    for (var i = 0; i < inputs.length; ++i) {
        inputs.item(i).addEventListener("change", function (ev) {
            var errors = validate(form, constraints) || {};
            showErrorsForInput(this, errors[this.name])
        });
    }

    function handleFormSubmit(form, input) {
        var errors = validate(form, constraints);
        showErrors(form, errors || {});
        if (!errors) {
            showSuccess(form);
        }
    }

    function showErrors(form, errors) {
        _.each(form.querySelectorAll("input[name], select[name], textarea[name]"), function (input) {
            showErrorsForInput(input, errors && errors[input.name]);
        });
    }

    function showErrorsForInput(input, errors) {
        var formGroup = closestParent(input.parentNode, "form-group"),
            messages = formGroup.querySelector(".messages");
        resetFormGroup(formGroup);
        if (errors) {
            formGroup.classList.add("has-error");
            _.each(errors, function (error) {
                addError(messages, error);
            });
        } else {
            formGroup.classList.add("has-success");
        }
    }

    function closestParent(child, className) {
        if (!child || child == document) {
            return null;
        }
        if (child.classList.contains(className)) {
            return child;
        } else {
            return closestParent(child.parentNode, className);
        }
    }

    function resetFormGroup(formGroup) {
        formGroup.classList.remove("has-error");
        formGroup.classList.remove("has-success")
        _.each(formGroup.querySelectorAll(".help-block.error"), function (el) {
            el.parentNode.removeChild(el);
        });
    }

    function addError(messages, error) {
        var block = document.createElement("p");
        block.classList.add("help-block");
        block.classList.add("error");
        block.innerText = error;
        messages.appendChild(block);
    }

    function showSuccess(form) {
        return fetch('http://78.47.49.191/addTask', {
            method: 'POST',
            'headers': {
                'Content-type': 'application/x-www-form-urlencoded'
            },
            body: $(form).serialize()
        }).then(function (c) {
            c.json().then(function (r) {
                if (r['success']) {
                    form.reset();
                    toastr.success('Task successfully created', {timeOut: 3000})
                }
            })
        }).catch(function () {

        }).finally(function () {
            table.ajax.reload(null, false);
        })
    }

    $('#tasks').on('click', '.edit', function () {
        let title = $('.modal-title');
        let text = $('#taskText');
        let saveB = $('#saveChanges');
        title.text('')
        text.val('')
        saveB.attr('data-id', '')
        let current_id = $(this).data('id');
        saveB.attr('data-id', current_id)
        return fetch('http://78.47.49.191/getTask/?id=' + current_id).then(function (c) {
            c.json().then(function (r) {
                if (r) {
                    title.text(r['name'])
                    text.val(r['text'])
                }
            })
        }).catch(function () {

        })
    })

    $('#saveChanges').on('click', function () {
        let _id = $(this).attr('data-id');
        let newText = $('#taskText').val();
        return fetch('http://78.47.49.191/editTask', {
            method: 'POST',
            'headers': {
                'Content-type': 'application/x-www-form-urlencoded'
            },
            body: `id=${_id}&text=${newText}`
        }).then(function (c) {
            c.json().then(function (r) {
                if (r['success']) {
                    form.reset();
                    toastr.success('Task successfully changed', {timeOut: 3000})
                }
            })
        }).catch(function () {

        }).finally(function () {
            table.ajax.reload(null, false);
        })
    })
})