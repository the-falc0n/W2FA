<h2 class="nav-tab-wrapper">
    <?php foreach ( $tabs as $tab ):
        $tab_url = '?' . http_build_query( [ 'page' => $page, 'tab' => $tab['slug'] ] );
        ?>
        <?php if ( $current_tab && $current_tab === $tab['slug'] ): ?>
            <?php
                add_action( "ski_wtfa_resolve_{$page}_tabs", $tab['view'] );
            ?>
            <span class="nav-tab nav-tab-active"><?php echo $tab['title']; ?></span>
        <?php else: ?>
            <a href="<?php echo $tab_url; ?>" class="nav-tab"><?php echo $tab['title']; ?></a>
        <?php endif; ?>
    <?php endforeach; ?>
</h2>
