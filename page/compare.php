<div class="container pt-2">
    <h2>Portfolio Heading</h2>
    <div class="row">
        <div class="card-group">
            <?php for ($i = 0; $i < 3; $i++) { ?>
                <div class="card">
                    <img src="http://placehold.it/700x400" class="card-img-top" alt="...">

                    <div class="card-body">
                        <h5 class="card-title"><?= "var carName"?></h5>
                        <p class="card-text"><?= "var car description"?></p>

                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Cras justo odio</li>
                        <li class="list-group-item">Dapibus ac facilisis in</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</div>