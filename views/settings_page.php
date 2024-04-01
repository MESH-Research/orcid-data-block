<?php
/**
 * Settings page template
 *
 * @package OrcidDataBlock
 */

?>
<div class="wrap">
    <h2>ORCID Profile Settings</h2>
    <form method="POST" id="orcidForm">
    <!-- wp_nonce_field used for security (see above comment) -->
    <?php wp_nonce_field('orcid_nonce'); ?>
    <!-- need to replace table with CSS -->
    <?php if (!empty($success)) : ?>
        <div class="updated"><p><?php echo __('ORCID ID updated.', 'orcid-data-block'); ?></p></div>
    <?php endif; ?>
    <table>
        <tr>
        <td><label for="orcid_id">ORCID ID</label></td>
        <td>
            <input type="text" name="orcid_id" id="orcid_id" value="<?php echo esc_attr($orcid_id); ?>">
            <?php if (!empty($orcid_error)) : ?>
                <div class="error"><?php echo $orcid_error; ?></div>
            <?php endif; ?>
            </td>
        </tr>
        <tr>
        <td>            <input type="submit" name="submit" value="Update" class="button-primary" /></td>

        </tr>
    </table>
    </form>

    <h2>Your ORCID Profile</h2>
    <?php if (!empty($orcid_data)) : ?>
      <?php if (!empty($orcid_data['fetched'])) : ?>
        <?php
          $fetched = new \DateTime();
          $fetched->setTimestamp($orcid_data['fetched']);
        ?>


          <p>Last downloaded: <?php echo esc_html($fetched->format('Y-m-d H:i:s e')); ?></p>
        <?php endif; ?>
      <p>Here is the data from your ORCID profile:</p>
      <pre><?php echo esc_html($orcid_data['xml']); ?></pre>
    <?php endif; ?>
</div>
