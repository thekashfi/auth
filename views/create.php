<?php $this->layout('layout', ['title' => 'Create contact']) ?>

<div class="container">
    <?= $this->insert('navbar') ?>

    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <form action="https://webhook.site/14e51441-12f1-4efa-8bfc-5334838e1bc2" method="post" id="createForm">
                    <div class="card-body py-5">
                        <div class="row">
                            <div class="col-lg-3 text-center">
                                <label for="avatar">
                                    <img src="<?= asset('images/default.jpg') ?>" class="img-fluid mb-3" alt="user" />
                                </label>
                                <input type="file" class="form-control-file" id="avatar">
                            </div>
                            <div class="col-lg-9">
                                <form action="">
                                    <div class="form-group">
                                        <input class="form-control form-control-plaintext w-25 d-inline-block" type="text" name="first_name" placeholder="First name">
                                        <input class="form-control form-control-plaintext w-25 d-inline-block" type="text" name="last_name" placeholder="Last name">
                                        <input class="form-control form-control-sm mt-2 form-control-plaintext" type="text" name="phone" placeholder="Phone number">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="p-1"><label for="email" class="mb-0">Email</label></th>
                                                    <td class="p-1"><input type="email" class="form-control-plaintext py-0" id="email" name="email" placeholder="email@example.com"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1"><label class="mb-0">Gender</label></th>
                                                    <td class="p-1">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
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
                                                            <input class="form-check-input" type="radio" name="name_title" id="Mr" value="Mr">
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
                                                    <td class="p-1"><input name="country" type="text" class="form-control-plaintext py-0" id="country" placeholder="country"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="p-1"><label for="city" class="mb-0">City</label></th>
                                                    <td class="p-1"><input name="city" type="text" class="form-control-plaintext py-0" id="city" placeholder="city"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="create">Create</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#createForm").submit(function(e) {
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
                let Done = () => `
                        <img src="images/tick.png" alt="tick" style="width: 30px" class="d-inline-block"/>
                        <p class="d-inline-block">ثبت شد</p>
                    `;
                $("#create").replaceWith(Done());
            },
            error: () => alert('Something went wrong!')
        });
    });
</script>

<script>
    feather.replace()
</script>