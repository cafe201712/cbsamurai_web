<div class="container-fluid">
    <div class="row">
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php foreach ($images as $idx => $image): ?>
                    <li data-target="#carousel" data-slide-to="<?= $idx ?>" class="<?= $idx === 0 ? 'active' : ''; ?>"></li>
                <?php endforeach; ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php foreach ($images as $idx => $image): ?>
                    <div class="item <?= $idx === 0 ? 'active' : ''; ?>">
                        <img src="<?= $image ?>">
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
