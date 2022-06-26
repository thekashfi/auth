<?php $this->layout('layout', ['title' => 'Show contact']) ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card m-b-30">
            <div class="card-body py-5">
                <div class="row">
                    <div class="col-lg-3 text-center">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" class="img-fluid w-100 mb-3" alt="user" />
                    </div>
                    <div class="col-lg-9">
                        <h4>John Doe</h4>
                        <p>09171231234</p>
                        <div class="button-list mt-4 mb-3">
                            <button type="button" class="btn btn-primary-rgba"><i class="feather mr-1" data-feather="message-square"></i>Message</button>
                            <button type="button" class="btn btn-success-rgba"><i class="feather mr-1" data-feather="phone"></i>Call Now</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="p-1">Email :</th>
                                        <td class="p-1">example@email.com</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="p-1">Gender :</th>
                                        <td class="p-1">Male</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="p-1">Country :</th>
                                        <td class="p-1">Iran</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="p-1">City :</th>
                                        <td class="p-1">Shiraz</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    feather.replace()
</script>