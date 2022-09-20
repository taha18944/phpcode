<aside class="left-sidebar" style="background-color: #F6F6F6;">
  <div class="scroll-sidebar">
    <nav class="sidebar-nav">
      <ul id="sidebarnav" class="pt-4">
        <?php for($i = 0 ; $i < count($_SESSION['menus']); $i++) {?>
        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link"  href="<?=BASE_URL?><?php echo $_SESSION['menus'][$i]->menu_link; ?>" aria-expanded="false">
            <i class="<?= $_SESSION['menus'][$i]->icon; ?>"></i>
            <span class="hide-menu"><?= $_SESSION['menus'][$i]->menu_name;?></span>
          </a>
        </li>
        <?php }?>
      </ul>
    </nav>
  </div>
</aside>