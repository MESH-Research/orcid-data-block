<?php
/**
 * Settings page template
 *
 * @package OrcidDataBlock
 */

?>
<div class="wrap">
    <h2>ORCiD Profile Settings</h2>
    <form method="POST" id="orcidForm">
    <!-- wp_nonce_field used for security (see above comment) -->
    <?php wp_nonce_field('orcid_nonce'); ?>
    <!-- need to replace table with CSS -->
    <?php if ($success) : ?>
        <div class="updated"><p><?php echo __('ORCiD ID updated.', 'orcid-data-block'); ?></p></div>
    <?php endif; ?>
    <table>
        <tr>
        <td><label for="orcid_id">ORCiD ID</label></td>
        <td>
            <input type="text" name="orcid_id" id="orcid_id" value="<?php echo esc_attr($orcid_id); ?>">
            <?php if ($orcid_error) : ?>
                <div class="error"><?php echo $orcid_error; ?></div>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
        <td><input type="submit" name="submit" value="Update" class="button-primary" /></td>
        </tr>
    </table>
    </form>
</div>
