<?php
if ( ! defined( 'ABSPATH' ) ) {
	echo esc_html(__("Hey, you don't have permission to access this file", 'novinhub'));
	exit;
}

?>
<div class="wrap">
    <h1 <?php if ( get_locale() === 'fa_IR' ) {
		echo 'class="text-right"';
	} ?>><?php echo esc_html(__( 'Novinhub Plugin', 'novinhub' )) ?></h1>

    <form method="post"
          action="options.php" <?php if ( get_locale() === 'fa_IR' ) {
		echo 'class="text-right"';
	} ?>>
		<?php
		settings_fields( 'novinhub_options_group' );
		do_settings_sections( 'Novinhub_Plugin' );
		echo '<div style="display: flex; justify-content: center;">';
		submit_button( esc_html(__( 'Set Token', 'novinhub' )) );
		echo '</div>';
		?>
    </form>
	<?php
	
	use Novinhub\Client;
	
	try {
		$api      = new Client( esc_attr( get_option( 'novinhub_token' ) ) );
		$accounts = $api->get( 'account' );
		set_transient( 'novinhub_accounts', $accounts, '600' );
		
		$count = 0;
		foreach ( $accounts as $account ) {
				$count ++;
		}
		?>
        <p style="font-size: 1rem;"><?php echo esc_html(__( 'Number of accounts assigned to token:',
				'novinhub' )); ?> <span
                    style="color: red;"><?php echo $count; ?> </span></p>
		<?php
		echo '<div>';
		echo '<table id="novinhubAccountsTable">
            <thead>
                <th class="text-center" style="font-family: sans-serif">' . esc_html(__('ID', 'novinhub')) .'</th>
                <th class="text-center" style="font-family: sans-serif">' . esc_html(__('Name', 'novinhub')) .'</th>
                <th class="text-center" style="font-family: sans-serif">' . esc_html(__('Type', 'novinhub')) . '</th>
            </thead>
            <tbody>';
		foreach ( $accounts as $account ) {
				echo '<tr>';
				echo '<td class="text-center">' . $account['id'] . '</td>';
				echo '<td class="text-center">' . $account['name'] . '</td>';
				echo '<td class="text-center">' . $account['type'] . '</td>';
				echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>';
		
	} catch ( \Exception $e ) {
		$message = $e->getMessage();
		if ( $message === 'توکن نامعتبر است' ) {
			delete_option( 'novinhub_token' );
			echo '<div class="novinhub-alert novinhub-alert-danger" style="text-align: center">';
			echo '<strong>' . esc_html(__( 'Error',
					'novinhub' )) . '</strong> ' . esc_html(__( 'Invalid Token...',
					'novinhub' ));
		} else {
			delete_option( 'novinhub_token' );
			echo '<div class="novinhub-alert novinhub-alert-danger" style="text-align: center;">';
			echo '<strong>' . esc_html(__( 'Error',
					'novinhub' )) . '</strong> ' . $message;
		}
	}
 
	echo '</div>';
	?>



