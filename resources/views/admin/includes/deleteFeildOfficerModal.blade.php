<div class="modal fade" id="deleteFieldModal" tabindex="200" role="dialog" aria-labelledby="deleteFieldModal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{url('admin/delete/field-officer')}}" id="deleteFieldForm">
                @csrf
                @method('delete')
                
                <input type="hidden" name="id" id="deleteFieldId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFieldLable">Delete</h5>
                </div>
                <div class="modal-body">
                    <p>Sure you want to delete this field officer?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Delete</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
