<!-- resources/views/components/confirm-modal.blade.php -->
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">

<div class="modal fade" id="modal-confirmationsuppression" tabindex="-1" aria-labelledby="modal-confirmationsuppressionl" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this campaign ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gray" data-bs-dismiss="modal">Annuler</button>
                <form id="archive-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('modal-confirmationsuppression');

        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var campaignId = button.getAttribute('data-campaign-id'); 

            var form = modal.querySelector('form');
            if (form) {
                form.action = '{{ route("campaigns.archive", ":id") }}'.replace(':id', campaignId);
            }
        });
    });
</script>
