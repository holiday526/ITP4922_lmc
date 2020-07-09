<header>
    <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php $cars = queryBuilderPrepare('cars', ['*'], ['sold'=>0],['id'=>'desc'], [],5) ?>
            <?php for ($i = 0; $i < count($cars); $i++) { ?>
            <?php   if ($i == 0) { ?>
                <li data-target="#carouselIndicators" data-slide-to="<?= $i ?>" class="active"></li>
            <?php } else { ?>
                <li data-target="#carouselIndicators" data-slide-to="<?= $i ?>"></li>
            <?php
                }
            } ?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <!-- Slide One - Set the background image for this slide in the line below -->
            <?php for ($i = 0; $i < count($cars); $i++) { ?>

            <?php   if ($i == 0) { ?>
                <div class="carousel-item active" style="background-image: url('<?= $cars[$i]['photoLocation'] ?>')">
                    <div class="carousel-caption d-none d-md-block">
                        <h3><?= $cars[$i]['name'] ?></h3>
                        <p><?= $cars[$i]['description'] ?></p>
                    </div>
                </div>
            <?php } else { ?>
                <div class="carousel-item" style="background-image: url('<?= $cars[$i]['photoLocation'] ?>')">
                    <div class="carousel-caption d-none d-md-block">
                        <h3><?= $cars[$i]['name'] ?></h3>
                        <p><?= $cars[$i]['description'] ?></p>
                    </div>
                </div>
                    <?php
                }
            } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>