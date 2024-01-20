<div class="slider">
    <?php
    $ids = array(1, 2, 3, 4);
    $alt = array(
        "Slide 1",
        "Slide 2",
        "Slide 3",
        "Slide 4"
    );
    $max = count($ids);
    for ($s = 0; $s < $max; $s++) { ?>
        <input type="radio" id="<?= $ids[$s]; ?>" name="image-slide" hidden />
    <?php } ?>
    <div class="slideshow">
        <?php for ($s = 0; $s < $max; $s++) { ?>
            <div class="item-slide">
                <img src="views/img/<?= $ids[$s]; ?>.jpg" alt="<?= $alt[$s]; ?>" />
            </div>
        <?php } ?>
    </div>
    <div class="pagination">
        <?php for ($s = 0; $s < $max; $s++) { ?>
            <label class="pag-item" for="<?= $ids[$s]; ?>">
                <img src="views/img/<?= $ids[$s]; ?>.jpg" alt="<?= $alt[$s]; ?>" />
            </label>
        <?php } ?>
    </div>
</div>