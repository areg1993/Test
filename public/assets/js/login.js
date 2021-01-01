window.onload = function () {
    var constraints = {
        name: {
            presence: true,
            length: {
                minimum: 4
            }
        },
        password: {
            presence: true,
            length: {
                minimum: 3
            }
        }
    };

    var form = document.querySelector("form#login");
    form.addEventListener("submit", function (ev) {
        ev.preventDefault();
        handleFormSubmit(form);
    });

    var inputs = document.querySelectorAll("input")
    for (var i = 0; i < inputs.length; ++i) {
        inputs.item(i).addEventListener("change", function (ev) {
            var errors = validate(form, constraints) || {};
            console.log(errors)
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
        _.each(form.querySelectorAll("input"), function (input) {
            console.log(errors)
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
        formGroup.classList.remove("has-success");
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
        return fetch('http://78.47.49.191/login', {
            method: 'POST',
            'headers': {
                'Content-type': 'application/x-www-form-urlencoded'
            },
            body: $(form).serialize()
        }).then(function (c) {
            c.json().then(function (r) {
                if (r['success']) {
                    window.location.replace('http://78.47.49.191/')
                } else {
                    showErrorsForInput(document.querySelector("#InputName"), ["Name or password incorrect"])
                }
            })
        }).catch(function () {
        })
    }


}

