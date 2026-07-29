$(document).ready(function () {
    // Add New Sample / Edit Sample Form Submit
    $('#sampleForm').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var sampleId = $('#sample_id').val();
        var url = sampleId ? `/updateSamples/${sampleId}` : '/samples';

        console.log("Submitting to:", url);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log("Success:", response);
                $('#newSampleModal').modal('hide');
                location.reload();
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
                alert('An error occurred. Please check console for details.');
            }
        });
    });

    // Edit Sample Button Click
    $(document).on('click', '.edit-sample-btn', function () {
        var sampleId = $(this).data('id');

        $.get('/getSampleDetails/' + sampleId, function (data) {
            $('#newSampleModalLabel').text('Edit Sample');
            $('#sample_id').val(data.id);
            $('#title').val(data.title);
            $('#category').val(data.category);
            $('#description').val(data.description);
            $('#price').val(data.price);
            $('#stocks').val(data.stocks);
            $('#badge').val(data.badge);
            $('#badge_type').val(data.badge_type);
            $('#is_active').prop('checked', data.is_active == 1);

            $('#newSampleModal').modal('show');
        });
    });

    // Reset Modal on Close
    $('#newSampleModal').on('hidden.bs.modal', function () {
        $('#sampleForm')[0].reset();
        $('#sample_id').val('');
        $('#newSampleModalLabel').text('Add New Sample');
    });

    // Delete Sample
    $(document).on('click', '.delete-sample-btn', function () {
        var sampleId = $(this).data('id');
        if (confirm("Are you sure you want to delete this sample?")) {
            $.ajax({
                url: '/destroySamples/' + sampleId,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr) {
                    alert('Error deleting sample');
                }
            });
        }
    });
});
