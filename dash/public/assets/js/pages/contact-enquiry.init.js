/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Contact Enquiry Init Js File
*/

new gridjs.Grid({
    columns: [
        {
            name: "ID",
            width: "50px",
            formatter: function (cell) {
                return gridjs.html('<span class="fw-semibold">' + cell + '</span>');
            }
        },
        {
            name: "Name",
            formatter: function (cell) {
                return gridjs.html(cell);
            }
        },
        {
            name: "Email",
            formatter: function (cell) {
                return gridjs.html(cell);
            }
        },
        {
            name: "Phone",
            formatter: function (cell) {
                return gridjs.html(cell);
            }
        },
        {
            name: "Subject",
            formatter: function (cell) {
                return gridjs.html(cell);
            }
        },
        {
            name: "Date",
            formatter: function (cell) {
                return gridjs.html(cell);
            }
        },
        {
            name: "Action",
            sort: { enabled: false },
            formatter: function (cell, row) {
                // Access hidden columns if needed, assuming row.cells structure matches data order
                // Or better, pass the entire action object or construct needed data
                // Ideally, cell contains the ID or action URL. 
                // In controller we sent action_url and delete_url. 
                // But Grid.js formatter receives 'cell' value.
                // Let's adjust controller to send a single structure for this column OR use row data.

                // Correction: The controller sends:
                /*
                'id' => $message->id,
                ...
                'action_url' => ...,
                'delete_url' => ...
                */
                // We need to match columns to this data.
                // To simplify, let's assume the last column in data receives the ID (or an object with ID/URLs)
                // However, Grid.js works best if data structure matches columns.
                // We will use `server` config to map data correctly.

                return gridjs.html(
                    '<div class="d-flex gap-3">' +
                    '<a href="javascript:void(0);" data-url="' + cell.action_url + '" class="text-primary view-details" title="View Details"><i class="mdi mdi-eye font-size-18"></i></a>' +
                    '<form action="' + cell.delete_url + '" method="POST" class="d-inline-block delete-form">' +
                    '<input type="hidden" name="_token" value="' + document.querySelector('meta[name="csrf-token"]').getAttribute('content') + '">' +
                    '<input type="hidden" name="_method" value="DELETE">' +
                    '<a href="javascript:void(0);" onclick="if(confirm(\'Are you sure?\')) this.closest(\'form\').submit();" class="text-danger" title="Delete"><i class="mdi mdi-delete font-size-18"></i></a>' +
                    '</form>' +
                    '</div>'
                );
            }
        }
    ],
    pagination: {
        limit: 10
    },
    sort: true,
    search: true,
    server: {
        url: '/contact-messages/fetch',
        then: data => data.map(message => [
            message.id,
            message.name,
            message.email,
            message.phone,
            message.subject,
            message.created_at,
            { action_url: message.action_url, delete_url: message.delete_url } // Passed to Action column
        ])
    }
}).render(document.getElementById("table-contact-enquiries"));

// Re-bind click event for dynamic content
document.addEventListener('click', function (e) {
    if (e.target.closest('.view-details')) {
        var btn = e.target.closest('.view-details');
        var url = btn.getAttribute('data-url');

        // Reset modal
        document.getElementById('modal-name').innerText = '';
        document.getElementById('modal-email').innerText = '';
        document.getElementById('modal-phone').innerText = '';
        document.getElementById('modal-country').innerText = '';
        document.getElementById('modal-ip').innerText = '';
        document.getElementById('modal-subject').innerText = '';
        document.getElementById('modal-message').innerText = '';

        // Fetch details
        fetch(url)
            .then(response => response.json())
            .then(data => {
                var msg = data.message;

                document.getElementById('modal-name').innerText = msg.name;
                document.getElementById('modal-email').innerText = msg.email;
                document.getElementById('modal-phone').innerText = msg.phone;
                document.getElementById('modal-country').innerText = msg.country;
                document.getElementById('modal-ip').innerText = msg.ip_address;
                document.getElementById('modal-subject').innerText = msg.subject;
                document.getElementById('modal-message').innerText = msg.message;

                // Show modal (using Bootstrap 5 API if available, or jQuery fallback)
                var myModal = new bootstrap.Modal(document.getElementById('detailsModal'));
                myModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error fetching details');
            });
    }
});
