<?php
defined('ABSPATH') or exit;
function resolve_privacy_policy_link() {
    if(determine_locale() === 'pt_BR') {
        return 'https://castleit.notion.site/Streamcart-Pol-tica-de-Privacidade-9a9476ed960b4103bca3514ad95d281d';
    } else {
        return 'https://castleit.notion.site/Streamcart-Privacy-Policy-61a00a8d9f5a450d860b4786c5670b71';
    }
}

?>
<div id="streamcart-consent">
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="streamcart_consent_form" />
        <?php wp_nonce_field('streamcart_consent_form', 'streamcart_consent_form_nonce_field'); ?>

        <h3><?= __('Privacy Policy', 'streamcart') ?></h3>
        <p>
            <?= __('To enhance your experience with us, we would like to collect some personal information.<br>We assure you that all data will be handled with confidentiality and security, in accordance with the General Data Protection Law (GDPL).<br>By continuing, you agree to the use of your data as described in our', 'streamcart') ?>
            <a target="_blank" href="<?= resolve_privacy_policy_link() ?>"><?= __('Privacy Policy', 'streamcart') ?></a>
        </p>
        <table class="form-table">
            <tr>
                <td>
                    <input type="checkbox" id="streamcart_user_data_consent" name="streamcart_user_data_consent">
                    <label for="streamcart_user_data_consent">
                        <?= __('You should check in order to use the plugin', 'streamcart') ?>
                    </label>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
