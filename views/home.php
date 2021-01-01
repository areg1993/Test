<?php
use App\Core\Auth;
require_once VIEWS . 'layouts/header.php';
include(VIEWS . 'layouts/menu.php');
?>
    <script>
        window.isLogged = '<?=Auth::isLogged()?>'
    </script>
    <div class='container-fluid'>
        <div class="row justify-content-center">
            <div class="col-10 mt-5">
                <table id="tasks" class="table table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Text</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Settings</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="col-8 mt-5">
                <form id="task">
                    <div class="form-group">
                        <label for="iName">Name</label>
                        <input type="text" name="name" class="form-control" id="iName"
                               placeholder="Enter name">
                        <small class="form-text text-danger messages"></small>
                    </div>
                    <div class="form-group">
                        <label for="iEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="iEmail"
                               placeholder="Enter email">
                        <small class="form-text text-danger messages"></small>
                    </div>
                    <div class="form-group">
                        <label for="eText">Text</label>
                        <textarea name="text" class="form-control" id="eText" placeholder="Text"></textarea>
                        <small class="form-text   text-danger messages"></small>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
        <div id="taskModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea name="text" class="form-control" id="taskText" placeholder="Text"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="saveChanges" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once VIEWS . 'layouts/footer.php'; ?>