<div class="row">
    <div class="col-md-12">
        <div class="top-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="mr-4"><a href="<?= url('') ?>" class=" text-dark"><i class="feather" data-feather="<?= $icon ?? 'arrow-left' ?>"></i></a></li>
                    <li class="mr-4"><a href="<?= url('') ?>" class=" text-dark">Contacts</a></li>
                    <li class="mr-4"><a href="<?= url('create') ?>" class=" text-dark"><i class="feather" data-feather="plus"></i></a></li>


                    <div class="input-group rounded w-auto">
                        <input type="search" id="search" oninput="search(this)" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <span class="input-group-text border-0" id="search-addon">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>

                    <li class="ml-auto"><a href="<?= url('login') ?>" class=" text-dark"><i class="feather mr-1" data-feather="user"></i>Login |</a></li>
                    <li class=""><a href="<?= url('register') ?>" class=" text-dark">  Register</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>