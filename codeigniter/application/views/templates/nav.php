<div class="sidenav">

<h4 class="t-white my-pl-2 my-pr-2">
  <i class="material-icons" style="vertical-align: middle; font-size: inherit">group</i>
  <span style="vertical-align: middle;">Team-Planner</span>
</h4>

<nav>
  <ul>
    <?php foreach ($nav_items as $item): ?>
    <?php if ($item): ?>
    <li>
      <a class="mdl-js-ripple-effect" href="<?=base_url($item['href'])?>">
        <span class="mdl-ripple"></span>
        <?=$item['title']?>
      </a>
    </li>
    <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</nav>

<div class="my-p-1 my-pl-3 my-pr-3">
  <span class="t-white">&copy; Team-Planner <?=date('Y')?></span>
</div>

</div>