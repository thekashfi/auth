<?php $this->layout('layout', ['title' => 'Contacts list']) ?>

<div class="container">
    <!-- Navbar -->
    <div class="row">
        <div class="col-md-12">
            <div class="top-breadcrumb">
                <div class="input-group rounded">
                    <input type="search" id="search" oninput="search(this)" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <span class="input-group-text border-0" id="search-addon">
                            <i class="fas fa-search"></i>
                        </span>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="mr-4"><a href="index.html" class=" text-dark"><i class="feather" data-feather="list"></i></a></li>
                        <li class="mr-4"><a href="index.html" class=" text-dark">Contacts</a></li>
                        <li class="mr-4"><a href="create.html" class=" text-dark"><i class="feather" data-feather="plus"></i></a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

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