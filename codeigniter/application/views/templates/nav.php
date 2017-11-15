<nav>
  <ul>
    <?php foreach ($nav_items as $item): ?>
    <?php if ($item): ?>
    <li><a href="<?=base_url($item['href'])?>"><?=$item['title']?></a></li>
    <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</nav>