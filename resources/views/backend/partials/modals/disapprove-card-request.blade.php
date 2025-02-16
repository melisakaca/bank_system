<!-- Disapprove Modal -->
<div class="modal fade" id="disapproveModal" tabindex="-1" aria-labelledby="disapproveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disapproveModalLabel">Disapprove Card Request</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="disapproveForm" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="form-group">
                        <label for="reason">Reason for Disapproval</label>
                        <input type="text" name="reason" id="reason" class="form-control" placeholder="Enter reason" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="disapproveForm" class="btn btn-danger">Disapprove</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    
        $('#disapproveModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var requestId = button.data('request-id'); 
            var form = $('#disapproveForm'); 

           
            form.attr('action', '/card-requests-decisions/' + requestId + '/disapprove');
        });
    });
</script>