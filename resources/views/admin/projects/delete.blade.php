<div class="modal fade" id="deleteProjectsModal" tabindex="200" role="dialog" aria-labelledby="deleteProjectsModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
                <input type="hidden" name="id" id="deleteProjectsId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProjectsModalLabel">Delete</h5>
                </div>
                <div class="modal-body">
                    <p>Sure you want to delete this project?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" id="deleteProjectBtn" onclick="confirmDeleteProject();">Delete</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
