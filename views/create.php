<?php $this->layout('layout', ['title' => 'Create contact']) ?>

<div class="row">
    <!-- Start col -->
    <div class="col-lg-12">
        <div class="card m-b-30">
            <form action="<?= url('contacts/store') ?>" method="post" id="createForm">
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
                                    <input class="form-control w-25 d-inline-block" type="text" name="first_name" placeholder="First name">
                                    <input class="form-control w-25 d-inline-block" type="text" name="last_name" placeholder="Last name">
                                    <input class="form-control form-control-sm mt-2" type="text" name="phone" placeholder="Phone number">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="p-1"><label for="email" class="mb-0">Email</label></th>
                                                <td class="p-1"><input type="email" class="py-0" id="email" name="email" placeholder="email@example.com"></td>
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
            </form>
        </div>
    </div>
</div>

<script>
    //$("#createForm").submit(function(e) {
    //    e.preventDefault();
    //
    //    let form = $(this);
    //    let url = form.attr('action');
    //
    //    $.ajax({
    //        type: "POST",
    //        url: url,
    //        headers: {
    //            'Content-Type': 'application/x-www-form-urlencoded'
    //        },
    //        data: form.serialize(),
    //        success: function(data) {
    //            let Done = () => `
    //                    <img src="<?//= asset('images/tick.png') ?>//" alt="tick" style="width: 30px" class="d-inline-block"/>
    //                    <p class="d-inline-block">ثبت شد</p>
    //                `;
    //            $("#create").replaceWith(Done());
    //        },
    //        error: () => alert('Something went wrong!')
    //    });
    //});
</script>

<script>
    feather.replace()
</script>