<?php
defined('ABSPATH') or exit;
if (isset($_POST['streamcart_user_data_consent'])) {
    update_option('streamcart_user_data_consent', $_POST['streamcart_user_data_consent']);
}
?>
<div id="streamcart-consent">
    <form method="post">
        <?php settings_fields('streamcart'); ?>

        <h3><?= __('User Consent Data', 'streamcart') ?></h3>

        <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>

        <table class="form-table">
            <tr>
                <td>
                    <input type="checkbox" id="streamcart_user_data_consent" name="streamcart_user_data_consent">
                    <label for="streamcart_user_data_consent">
                        You should check in order to use the plugin
                    </label>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
