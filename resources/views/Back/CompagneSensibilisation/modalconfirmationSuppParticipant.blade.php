<!-- resources/views/components/confirm-modal.blade.php -->
<link rel="stylesheet" href="{{ asset('css/compaign.css') }}">

<div class="modal fade" id="modal-confirmationsuppression-participant" tabindex="-1" aria-labelledby="modal-confirmationsuppressionP" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this participant ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gray" data-bs-dismiss="modal">Annuler</button>
                <form id="archive-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('modal-confirmationsuppression-participant');

        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var participantId = button.getAttribute('data-participant-id'); 

            var form = modal.querySelector('form');
            if (form) {
                form.action = '{{ route("participation.delete", ":id") }}'.replace(':id', participantId);
            }
        });
    });
</script>