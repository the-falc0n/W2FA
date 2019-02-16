<div id="ski-wtfa" class="wrap">
    <div id="icon-themes" class="icon32"></div>
        <h2>Wordpress 2FA Settings</h2>
        <?php echo $tabs; ?>

        <form method="post"
              action="<?php menu_page_url( 'ski-wtfa-settings' ) ?>">
            <?php do_action( 'ski_wtfa_resolve_tabs', 'ski-wtfa-settings' ); ?>
            <?php do_action( 'ski_wtfa_resolve_ski-wtfa-settings_tabs' ); ?>

            <?php submit_button( 'Save', 'primary', 'ski-wtfa-setting' ); ?>
        </form>
</div>
