<table class="form-table">
    <tbody>
        <tr>
            <th>Two Factor Authentication</th>
            <td>
                <?php if( $is_tfa_enabled ) : ?>
                    <a href="<?php echo $totp_disable_url; ?>"
                       class="button button-red"
                       onclick="return confirm( 'Are You Sure?' );">Disable 2FA</button>
                <?php else : ?>
                    <a href="<?php echo $totp_setup_url; ?>"
                       class="button button-primary">Setup 2FA</a>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>
