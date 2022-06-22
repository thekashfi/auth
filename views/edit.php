<?php $this->layout('layout', ['title' => 'Edit contact']) ?>

<div class="container">
    <?= $this->insert('navbar') ?>

    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body py-5">
                    <form action="https://webhook.site/14e51441-12f1-4efa-8bfc-5334838e1bc2?id=10" method="post" id="editForm">
                        <div class="row">
                            <div class="col-lg-3 text-center">
                                <label for="avatar">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="img-fluid mb-3" alt="user" />
                                </label>
                                <input type="file" class="form-control-file" id="avatar">
                            </div>
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input class="form-control form-control-plaintext w-25 d-inline-block" type="text" name="first_name" placeholder="First name" value="John">
                                    <input class="form-control form-control-plaintext w-25 d-inline-block" type="text" name="last_name" placeholder="Last name" value="Doe">
                                    <input class="form-control form-control-sm mt-2 form-control-plaintext" name="phone" type="text" placeholder="Phone number" value="09172005000">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="p-1"><label for="email" class="mb-0">Email</label></th>
                                                <td class="p-1"><input type="email" class="form-control-plaintext py-0" id="email" name="email" placeholder="email@example.com" value="email@example.com"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1"><label class="mb-0">Gender</label></th>
                                                <td class="p-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                                                        <label class="form-check-label" for="male">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                                        <label class="form-check-label" for="female">Female</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1"><label class="mb-0">Title</label></th>
                                                <td class="p-1">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="name_title" id="Mr" value="Mr" checked>
                                                        <label class="form-check-label" for="Mr">Mr</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="name_title" id="Ms" value="Ms">
                                                        <label class="form-check-label" for="Ms">Ms</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1"><label for="country" class="mb-0">Country</label></th>
                                                <td class="p-1"><input name="country" type="text" class="form-control-plaintext py-0" id="country" placeholder="country" value="Italy"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="p-1"><label for="city" class="mb-0">City</label></th>
                                                <td class="p-1"><input name="city" type="text" class="form-control-plaintext py-0" id="city" placeholder="city" value="Shiraz"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="update">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#editForm").submit(function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: form.serialize(),
            success: function(data) {
                var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                createdAt = new Date(JSON.parse(data).createdAt * 1000).toLocaleDateString("fa-IR", options)

                let Done = (createdAt) => `
                        <img src="images/tick.png" alt="tick" style="width: 30px" class="d-inline-block"/>
                        <p class="d-inline-block">بروزرسانی شد: ${createdAt}</p>
                    `;
                $("#update").replaceWith(Done(createdAt));
            },
            error: () => alert('Something went wrong!')
        });
    });
</script>

<script>
    feather.replace()
</script>