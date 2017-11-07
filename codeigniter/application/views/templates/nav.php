<nav>
  <ul>
    <?php foreach ($nav_items as $item): ?>
    <li><a href="<?=base_url($item['href'])?>"><?=$item['title']?></a></li>
    <?php endforeach; ?>
  </ul>
</nav>