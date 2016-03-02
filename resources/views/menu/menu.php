<style>
    .menu li {
        display: inline;
        padding: 5px;
        margin: 3px;
        background-color: #99cb84;
        border-radius: 3px;
    }

    .menu a {
        text-decoration: none;
        color: white;
    }

    .menu li:hover {
        background-color: #000000;
    }
</style>
<div style="float: right;">
    <ul class="menu">
        <?php foreach ($actions as $action): ?>
            <li>
                <a href='/<?= $action ?>'>
                    <?= $action ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>
<div style="clear: both"></div>