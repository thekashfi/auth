<?php $this->layout('layout', ['title' => 'Contacts list']) ?>

<div class="container">
    <?= $this->insert('navbar', ['icon' => 'list']) ?>

    <div class="alert alert-success alert-dismissible fade show" style="display: none" id="delete_alert" role="alert">
        <strong>Contact</strong> has been deleted Successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="row" id="contacts-container">
        <img src="<?= asset('images/spinner.gif') ?>" alt="spinner" id="spinner" style="width: 50px; opacity: 50%" class="mx-auto mt-4">
    </div>

    <div class="row" id="pagination" style="display: none">
        <div class="container text-center">
            <nav>
                <ul class="pagination pagination-lg">
                    <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?page=2">2</a></li>
                    <li class="page-item"><a class="page-link" href="?page=3">3</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    function delete_form (id) {
        let url = 'https://webhook.site/14e51441-12f1-4efa-8bfc-5334838e1bc2?id=' + id;

        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            success: function(data) {
                $('#delete_alert').fadeIn()
            },
            error: () => alert('Something went wrong!')
        });
    };
</script>