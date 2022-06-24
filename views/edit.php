<?php $this->layout('layout', ['title' => 'Edit contact']) ?>

<div class="row">
    <!-- Start col -->
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body py-5">
                <form action="<?= url("contacts/update/{$contact->id}") ?>" method="post" id="editForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-3 text-center">
                            <label for="avatar">
                                <img src="<?= asset("images/{$contact->image}") ?>" class="img-fluid mb-3" alt="user"/>
                            </label>
                            <input type="file" name="image" class="form-control-file" id="avatar">
                        </div>
                        <div class="col-lg-9">
                            <div class="form-group">
                                <input class="form-control w-25 d-inline-block" type="text" name="first_name" placeholder="First name" value="<?= $contact->first_name ?>">
                                <input class="form-control w-25 d-inline-block" type="text" name="last_name" placeholder="Last name" value="<?= $contact->last_name ?>">
                                <input class="form-control form-control-sm mt-2"  name="phone" type="text" placeholder="Phone number" value="<?= $contact->phone ?>">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="p-1"><label for="email" class="mb-0">Email</label></th>
                                            <td class="p-1"><input type="email" class="py-0" id="email" name="email" placeholder="email@example.com" value="<?= $contact->email ?>"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="p-1"><label class="mb-0">Gender</label></th>
                                            <td class="p-1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= $contact->gender == 'male' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= $contact->gender == 'female' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                            </td>
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

<script>
    // $("#editForm").submit(function(e) {
    //     e.preventDefault();
    //
    //     // let form = $(this);
    //     let form = new FormData(this);
    //     // let url = form.attr('action');
    //     let url = $(this).attr('action');
    //
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         headers: {
    //             'Content-Type': 'application/x-www-form-urlencoded'
    //         },
    //         data: form,
    //         cache:false,
    //         contentType: false,
    //         processData: false,
    //         success: function(data) {
    //             console.log(data)
    //             // var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    //             // createdAt = new Date(JSON.parse(data).createdAt * 1000).toLocaleDateString("fa-IR", options)
    //             //
    //             // let Done = (createdAt) => `
    //             //         <img src="images/tick.png" alt="tick" style="width: 30px" class="d-inline-block"/>
    //             //         <p class="d-inline-block">بروزرسانی شد: ${createdAt}</p>
    //             //     `;
    //             // $("#update").replaceWith(Done(createdAt));
    //         },
    //         error: () => alert('Something went wrong!')
    //     });
    // });
</script>

<script>
    feather.replace()
</script>