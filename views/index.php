<?php $this->layout('layout', ['title' => 'Contacts list']) ?>

<div class="container">
    <?= $this->insert('navbar', ['icon' => 'list']) ?>

    <?= $this->insert('flash', ['icon' => 'list']) ?>

    <div class="row" id="contacts-container">
        <img src="<?= asset('images/spinner.gif') ?>" alt="spinner" id="spinner" style="width: 50px; opacity: 50%" class="mx-auto mt-4">
        <script>
            /* Card template in JQuery*/
            const Item = (result) => `
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-body py-5">
                            <div class="row">
                                <div class="col-lg-3 text-center">
                                    <a href="show.html"><img src="${result.picture.large}" class="img-fluid mb-3" alt="user" /></a>
                                </div>
                                <div class="col-lg-9">
                                    <a href="show.html"><h4>${result.name.title}. ${result.name.first} ${result.name.last}</h4></a>
                                    <p>${result.phone}</p>
                                    <div class="button-list mt-4 mb-3">
                                        <button type="button" class="btn btn-primary-rgba"><i class="feather mr-1" data-feather="message-square"></i>Message</button>
                                        <button type="button" class="btn btn-success-rgba"><i class="feather mr-1" data-feather="phone"></i>Call Now</button>
                                        <button type="button" class="btn btn-light" onclick="
                                                if(confirm (\`آیا از حذف ${result.name.title}. ${result.name.first} ${result.name.last} مطمئن هستید؟\`)) {
                                                    delete_form('${result.id.value}');
                                                }
                                            "><i class="feather" data-feather="trash-2"></i></button>
                                        <form action="" method="post" id="delete_form_${result.id.value}" class="delete_form" data="${result.id.value}" hidden></form>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row" class="p-1">Email :</th>
                                                <td class="p-1">${result.email}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">Gender :</th>
                                                <td class="p-1">${result.gender}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">Country :</th>
                                                <td class="p-1">${result.location.country}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1">City :</th>
                                                <td class="p-1">${result.location.city}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        </script>
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