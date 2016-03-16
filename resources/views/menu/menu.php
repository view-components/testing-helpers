<style>
    .demo-menu>li {
        display: inline-block;
        padding: 5px;
        margin: 1px;
        background-color: #99cb84;
        border-radius: 3px;
    }

    .demo-menu>li>a {
        text-decoration: none;
        color: white;
        font-size: small;
    }

    .demo-menu>li:hover {
        background-color: #000000;
    }
</style>
<div style="float: right; margin: 5px">
    <ul class="demo-menu">
        <?php foreach ($actions as $action): ?>
            <li>
                <a href='/index.php/<?= $action ?>'>
                    <?= $action ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>
<div style="clear: both"></div>