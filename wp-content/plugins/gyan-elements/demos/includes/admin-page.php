<?php
// TMPL - Single Demo Preview, No more demos, Filters, List

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div class="wrap" id="gyan-sites-admin" data-slug="<?php echo esc_html( $global_cpt_meta['cpt_slug'] ); ?>">

	<?php
	if ( ! empty( $_GET['debug'] ) && 'yes' === $_GET['debug'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		?>
		<div class="gyan-sites-log">
			<?php Gyan_Sites_Importer_Log::get_instance()->display_data(); ?>
		</div>

	<?php } else { ?>

		<?php do_action( 'gyan_sites_before_site_grid' ); ?>

		<div class="theme-browser rendered">
			<div id="gyan-sites" class="themes wp-clearfix"></div>
			<div id="site-pages" class="themes wp-clearfix"></div>
			<div class="gyan-sites-result-preview" style="display: none;"></div>

			<div class="gyan-sites-popup" style="display: none;">
				<div class="overlay"></div>
				<div class="inner">
					<div class="heading">
						<h3><?php esc_html_e( 'Heading', 'gyan-elements' ); ?></h3>
						<span class="dashicons close dashicons-no-alt"></span>
					</div>
					<div class="gyan-sites-import-content"></div>
					<div class="gyn-btn-actions-wrap"></div>
				</div>
			</div>
		</div>

		<?php do_action( 'gyan_sites_after_site_grid' ); ?>

	<?php } ?>
</div>

<script type="text/template" id="tmpl-gyan-sites-compatibility-messages">

	<div class="skip-and-import">
		<div class="heading">
			<h3><?php esc_html_e( 'We\'re Almost There!', 'gyan-elements' ); ?></h3>
			<span class="dashicons close dashicons-no-alt"></span>
		</div>
		<div class="gyan-sites-import-content">

			<p><?php esc_html_e( 'You\'re close to importing the template. To complete the process, please clear the following conditions.', 'gyan-elements' ); ?></p>

			<ul class="gyan-site-contents">

				<# for ( code in data ) { #>
					<# if( Object.keys( data[ code ] ).length ) { #>

						<# for ( id in data[ code ] ) { #>
							<li>
								{{{ data[ code ][id].title }}}

								<# if ( data[ code ][id].tooltip ) { #>
									<span class="gyan-sites-tooltip-icon" data-tip-id="gyan-sites-skip-and-import-notice-{{id}}">
										<span class="dashicons dashicons-editor-help"></span>
									</span>
									<div class="gyan-sites-tooltip-message" id="gyan-sites-skip-and-import-notice-{{id}}" style="display: none;">
										{{{data[ code ][id].tooltip}}}
									</div>
								<# } #>
							</li>
						<# } #>

					<# } #>
				<# } #>

			</ul>

		</div>
		<div class="gyn-btn-actions-wrap">
			<# if( Object.keys( data['errors'] ).length ) { #>
				<a href="#" class="button button-hero button-primary gyan-demo-import disabled site-install-site-button"><?php esc_html_e( 'Skip & Import', 'gyan-elements' ); ?></a>
				<div class="button button-hero site-import-cancel"><?php esc_html_e( 'Cancel', 'gyan-elements' ); ?></div>
			<# } else {
				var plugin_update = data['warnings']['update-available'] || 0;
				if( plugin_update ) { #>
					<a href="<?php echo esc_url( network_admin_url( 'update-core.php' ) ); ?>" class="button button-hero button-primary" target="_blank"><?php esc_html_e( 'Update', 'gyan-elements' ); ?></a>
					<a href="#" class="button button-hero button-primary gyan-sites-skip-and-import-step"><?php esc_html_e( 'Skip & Import', 'gyan-elements' ); ?></a>
				<# } else { #>
					<a href="#" class="button button-hero button-primary gyan-sites-skip-and-import-step"><?php esc_html_e( 'Skip & Import', 'gyan-elements' ); ?></a>
					<div class="button button-hero site-import-cancel"><?php esc_html_e( 'Cancel', 'gyan-elements' ); ?></div>
				<# } #>
			<# } #>
		</div>
	</div>

</script>

<script type="text/template" id="tmpl-gyan-sites-no-sites">
	<div class="gyan-sites-no-sites">
		<div class="inner">
			<h3><?php esc_html_e( 'Sorry No Results Found.', 'gyan-elements' ); ?></h3>
			<div class="content">
				<div class="description">
					<div class="back-to-layout-button"><span class="button gyan-sites-back"><?php esc_html_e( 'Back to Templates', 'gyan-elements' ); ?></span></div>
				</div>
			</div>
		</div>
	</div>
</script>

<?php
// TMPL - Show Page Builder Sites
// type = 'page' or 'site'
?>
<script type="text/template" id="tmpl-gyan-sites-page-builder-sites">
	<# for ( site_id in data ) { #>
	<#
		var current_site_id     = site_id;
		var type                = data[site_id]['type'] || 'site';
		var wrapper_class       = data[site_id]['class'] || '';
		var page_site_id        = data[site_id]['site_id'] || '';
		var featured_image_url = data[site_id]['featured-image-url'];
		var thumbnail_image_url = data[site_id]['thumbnail-image-url'] || featured_image_url;

		var site_type = data[site_id]['gyan-sites-type'] || '';
		var page_id = '';
		if ( 'site' === type ) {
		} else {
			thumbnail_image_url = featured_image_url;
			current_site_id = page_site_id;
			page_id = site_id;
		}

		var title = data[site_id]['title'] || '';
		var pages_count = parseInt( data[site_id]['pages-count'] ) || 0;
		var pages_count_class = '';
		var pages_count_string = ( pages_count !== 1 ) ? pages_count + ' Templates' : pages_count + ' Template';
		if( 'site' === type ) {
			if( pages_count ) {
				pages_count_class = 'has-pages';
			} else {
				pages_count_class = 'no-pages';
			}
		}
		var site_title = data[site_id]['site-title'] || '';

	#>
	<div class="theme gyan-theme site-single {{pages_count_class}} gyan-sites-previewing-{{type}} {{wrapper_class}}" data-site-id="{{current_site_id}}" data-page-id="{{page_id}}">
		<div class="inner">
			<span class="site-preview" data-title="{{{title}}}">
				<div class="theme-screenshot one loading" data-src="{{thumbnail_image_url}}" data-featured-src="{{featured_image_url}}"></div>
			</span>
			<div class="theme-id-container">
				<div class="theme-name">
					<span class="title">
						<# if ( 'site' === type ) { #>
							<div class='site-title'>{{{title}}}</div>
							<# if ( pages_count ) { #>
								<div class='pages-count'>{{{pages_count_string}}}</div>
							<# } #>
						<# } else { #>
							<div class='site-title'>{{{site_title}}}</div>
							<div class='page-title'>{{{title}}}</div>
						<# } #>
					</span>
				</div>
			</div>
		</div>
	</div>
	<# } #>

</script>

<?php
// TMPL - Show Page Builder Sites
?>
<script type="text/template" id="tmpl-gyan-sites-page-builder-sites-search">
	<# var pages_list = []; #>
	<# var sites_list = []; #>
	<# var pages_list_arr = []; #>
	<# var sites_list_arr = []; #>
	<# for ( site_id in data ) {
		var type = data[site_id]['type'] || 'site';
		if ( 'site' === type ) {
			sites_list_arr.push( data[site_id] );
			sites_list[site_id] = data[site_id];
		} else {
			pages_list_arr.push( data[site_id] );
			pages_list[site_id] = data[site_id]
		}
	} #>
	<# if ( sites_list_arr.length > 0 ) { #>
		<h3 class="gyn-sites__search-title"><?php esc_html_e( 'Site Templates', 'gyan-elements' ); ?></h3>
		<div class="gyn-sites__search-wrap">
		<# for ( site_id in sites_list ) { #>
		<#
			var current_site_id     = site_id;
			var type                = sites_list[site_id]['type'] || 'site';
			var page_site_id        = sites_list[site_id]['site_id'] || '';
			var featured_image_url = sites_list[site_id]['featured-image-url'];
			var thumbnail_image_url = sites_list[site_id]['thumbnail-image-url'] || featured_image_url;

			var site_type = sites_list[site_id]['gyan-sites-type'] || '';
			var page_id = '';

			var title = sites_list[site_id]['title'] || '';
			var pages_count = parseInt( sites_list[site_id]['pages-count'] ) || 0;
			var pages_count_string = ( pages_count !== 1 ) ? pages_count + ' Templates' : pages_count + ' Template';
			var pages_count_class = '';
			if( pages_count ) {
				pages_count_class = 'has-pages';
			} else {
				pages_count_class = 'no-pages';
			}
			var site_title = sites_list[site_id]['site-title'] || '';

		#>
			<div class="theme gyan-theme site-single {{pages_count_class}} gyan-sites-previewing-{{type}}" data-site-id="{{current_site_id}}" data-page-id="{{page_id}}">
				<div class="inner">
					<span class="site-preview" data-title="{{{title}}}">
						<div class="theme-screenshot one loading" data-src="{{thumbnail_image_url}}" data-featured-src="{{featured_image_url}}"></div>
					</span>
					<div class="theme-id-container">
						<div class="theme-name">
							<span class="title">
								<# if ( 'site' === type ) { #>
									<div class='site-title'>{{{title}}}</div>
									<# if ( pages_count ) { #>
										<div class='pages-count'>{{{pages_count_string}}}</div>
									<# } #>
								<# } else { #>
									<div class='site-title'>{{{site_title}}}</div>
									<div class='page-title'>{{{title}}}</div>
								<# } #>
							</span>
						</div>
					</div>
				</div>
			</div>
		<# } #>
		</div>
	<# } #>
	<# if ( pages_list_arr.length > 0 ) { #>

		<h3 class="gyn-sites__search-title"><?php esc_html_e( 'Page Templates', 'gyan-elements' ); ?></h3>
		<div class="gyn-sites__search-wrap">
		<# for ( site_id in pages_list ) { #>
		<#
			var current_site_id     = site_id;
			var type                = pages_list[site_id]['type'] || 'site';
			var page_site_id        = pages_list[site_id]['site_id'] || '';
			var featured_image_url = pages_list[site_id]['featured-image-url'];
			var thumbnail_image_url = pages_list[site_id]['thumbnail-image-url'] || featured_image_url;

			var site_type = pages_list[site_id]['gyan-sites-type'] || '';
			var page_id = '';
			thumbnail_image_url = featured_image_url;
			current_site_id = page_site_id;
			page_id = site_id;

			var title = pages_list[site_id]['title'] || '';
			var pages_count = pages_list[site_id]['pages-count'] || 0;
			var pages_count_class = '';
			if( 'site' === type ) {
				if( pages_count ) {
					pages_count_class = 'has-pages';
				} else {
					pages_count_class = 'no-pages';
				}
			}
			var site_title = pages_list[site_id]['site-title'] || '';

		#>
			<div class="theme gyan-theme site-single {{pages_count_class}} gyan-sites-previewing-{{type}}" data-site-id="{{current_site_id}}" data-page-id="{{page_id}}">
				<div class="inner">
					<span class="site-preview" data-title="{{{title}}}">
						<div class="theme-screenshot one loading" data-src="{{thumbnail_image_url}}" data-featured-src="{{featured_image_url}}"></div>
					</span>
					<div class="theme-id-container">
						<div class="theme-name">
							<span class="title">
								<div class='site-title'>{{{site_title}}}</div>
								<div class='page-title'>{{{title}}}</div>
							</span>
						</div>
					</div>
				</div>
			</div>
		<# } #>
		</div>
	<# } #>

</script>

<?php
// TMPL - Third Party Required Plugins
?>
<script type="text/template" id="tmpl-gyan-sites-third-party-required-plugins">
	<div class="skip-and-import">
		<div class="heading">
			<h3><?php esc_html_e( 'Required Plugins Missing', 'gyan-elements' ); ?></h3>
			<span class="dashicons close dashicons-no-alt"></span>
		</div>
		<div class="gyan-sites-import-content">
			<p><?php esc_html_e( 'This demo template requires premium plugins. As these are third party premium plugins, you\'ll need to install and activate them first.', 'gyan-elements' ); ?></p>
			<ul class="gyan-sites-third-party-required-plugins">
				<# for ( key in data ) { #>
					<li class="plugin-card plugin-card-{{data[ key ].slug}}'" data-slug="{{data[ key ].slug }}" data-init="{{data[ key ].init}}" data-name="{{data[ key ].name}}"><a href="{{data[ key ].link}}" target="_blank">{{data[ key ].name}}</a></li>
				<# } #>
			</ul>
		</div>
		<div class="gyn-btn-actions-wrap">
			<a href="#" class="button button-hero button-primary gyan-sites-skip-and-import-step"><?php esc_html_e( 'Skip & Import', 'gyan-elements' ); ?></a>
			<div class="button button-hero site-import-cancel"><?php esc_html_e( 'Cancel', 'gyan-elements' ); ?></div>
		</div>
	</div>
</script>

<?php
// TMPL - Single Site Preview
?>
<script type="text/template" id="tmpl-gyan-sites-single-site-preview">
	<div class="single-site-wrap">
		<div class="single-site">
			<div class="single-site-preview-wrap">
				<div class="single-site-pages-header">
					<h3 class="gyan-site-title">{{{data['title']}}}</h3>
					<span class="count" style="display: none"></span>
				</div>
				<div class="single-site-preview">
					<img class="theme-screenshot" data-src="" src="{{data['featured-image-url']}}" />
				</div>
			</div>
			<div class="single-site-pages-wrap">
				<div class="gyan-pages-title-wrap">
					<span class="gyan-pages-title"><?php esc_html_e( 'Page Templates', 'gyan-elements' ); ?></span>
				</div>
				<div class="single-site-pages">
					<div id="single-pages">
						<# for ( page_id in data.pages ) {
							var dynamic_page = data.pages[page_id]['dynamic-page'] || 'no'; #>
							<div class="theme gyan-theme site-single" data-page-id="{{page_id}}" data-dynamic-page="{{dynamic_page}}" >
								<div class="inner">
									<#
									var featured_image_class = '';
									var featured_image = data.pages[page_id]['featured-image-url'] || '';
									if( '' === featured_image ) {
										featured_image = '<?php echo esc_url( GYAN_PLUGIN_URI . 'demos/assets/images/placeholder.png' ); ?>';
										featured_image_class = ' no-featured-image ';
									}

									var thumbnail_image = data.pages[page_id]['thumbnail-image-url'] || '';
									if( '' === thumbnail_image ) {
										thumbnail_image = featured_image;
									}
									#>
									<span class="site-preview" data-title="{{ data.pages[page_id]['title'] }}">
										<div class="theme-screenshot one loading {{ featured_image_class }}" data-src="{{ thumbnail_image }}" data-featured-src="{{ featured_image }}"></div>
									</span>
									<div class="theme-id-container">
										<h3 class="theme-name">
											{{{ data.pages[page_id]['title'] }}}
										</h3>
									</div>
								</div>
							</div>
						<# } #>
					</div>
				</div>
			</div>
			<div class="single-site-footer">
				<div class="site-action-buttons-wrap">
					<a href="{{data['gyan-site-url']}}/" class="button button-hero site-preview-button" target="_blank">Preview "{{{data['title']}}}" Site <i class="dashicons dashicons-external"></i></a>
					<div class="site-action-buttons-right">
						<div class="button button-hero button-primary site-import-site-button"><i class="dashicons dashicons-download"></i><?php esc_html_e( 'Import Complete Site', 'gyan-elements' ); ?></div>
						<div class="button button-hero button-primary site-import-layout-button disabled"><?php esc_html_e( 'Import Template', 'gyan-elements' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-gyan-sites-site-import-success">
	<div class="heading">
		<h3><?php esc_html_e( 'Imported Successfully!', 'gyan-elements' ); ?></h3>
		<span class="dashicons close dashicons-no-alt"></span>
	</div>
	<div class="gyan-sites-import-content gyan-demo-import-done">
		<p class="gyan-demo-import-done-circle"><span class="dashicons dashicons-yes"></span></p>
		<p><b><?php esc_html_e( 'All Done! Demo Website is successfully installed!', 'gyan-elements' ); ?></b></p>
	</div>
	<div class="gyn-btn-actions-wrap">
		<a class="button button-primary button-hero" href="<?php echo esc_url( site_url() ); ?>" target="_blank"><?php esc_html_e( 'View Your Website', 'gyan-elements' ); ?> <i class="dashicons dashicons-external"></i></a>
	</div>
</script>

<script type="text/template" id="tmpl-gyan-sites-page-import-success">
	<div class="heading">
		<h3><?php esc_html_e( 'Imported Successfully!', 'gyan-elements' ); ?></h3>
		<span class="dashicons close dashicons-no-alt"></span>
	</div>
	<div class="gyan-sites-import-content gyan-demo-import-done">
		<p class="gyan-demo-import-done-circle"><span class="dashicons dashicons-yes"></span></p>
		<p><b><?php esc_html_e( 'All Done! Demo Template is successfully installed!', 'gyan-elements' ); ?></b></p>
	</div>
	<div class="gyn-btn-actions-wrap">
		<a class="button button-primary button-hero" href="{{data['link']}}" target="_blank"><?php esc_html_e( 'View Template', 'gyan-elements' ); ?> <i class="dashicons dashicons-external"></i></a>
	</div>
</script>

<?php
// TMPL - Import Process Interrupted
?>
<script type="text/template" id="tmpl-gyan-sites-request-failed">
	<p><?php esc_html_e( 'Your website is facing a temporary issue connecting to the template server.', 'gyan-elements' ); ?></p>
	<p>
		<?php
		/* translators: %s doc link. */
		printf( __( 'Read an article <a href="%s" target="_blank">here</a> to resolve the issue.', 'gyan-elements' ), 'https://bizixdocs.premiumthemes.in/one-click-demo-install-problems/' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</p>
</script>

<?php
// TMPL - Dynamic Page
?>
<script type="text/template" id="tmpl-gyan-sites-dynamic-page">
	<div class="skip-and-import">
		<div class="heading">
			<h3><?php esc_html_e( 'Heads Up!', 'gyan-elements' ); ?></h3>
			<span class="dashicons close dashicons-no-alt"></span>
		</div>
		<div class="gyan-sites-import-content">
			<p><?php esc_html_e( 'The page template you are about to import contains a dynamic widget/module. Please note this dynamic data will not be available with the imported page.', 'gyan-elements' ); ?></p>
			<p><?php esc_html_e( 'You will need to add it manually on the page.', 'gyan-elements' ); ?></p>
			<p><?php esc_html_e( 'This dynamic content will be available when you import the entire site.', 'gyan-elements' ); ?></p>
		</div>
		<div class="gyn-btn-actions-wrap">
			<a href="#" class="button button-hero button-primary gyan-sites-skip-and-import-step"><?php esc_html_e( 'Skip & Import', 'gyan-elements' ); ?></a>
			<div class="button button-hero site-import-cancel"><?php esc_html_e( 'Cancel', 'gyan-elements' ); ?></div>
		</div>
	</div>
</script>

<?php
// TMPL - First Screen
?>
<script type="text/template" id="tmpl-gyan-sites-result-preview">

	<div class="overlay"></div>
	<div class="inner">

		<div class="default">
			<div class="heading">
				<# if( 'gyan-sites' === data ) { #>
					<h3><?php esc_html_e( 'Let\'s import content to your website..', 'gyan-elements' ); ?></h3>
				<# } else { #>
					<h3><?php esc_html_e( 'Let\'s import template to your website..', 'gyan-elements' ); ?></h3>
				<# } #>
				<span class="dashicons close dashicons-no-alt"></span>
			</div>

			<div class="gyan-sites-import-content">
				<div class="install-theme-info">
					<div class="gyan-sites-advanced-options-wrap">
						<div class="gyan-sites-advanced-options">
							<p>When you import the data following things will happen:</p>
							<ul style="list-style:disc; padding-left:20px;">
								<li>No existing posts, pages, categories, images, custom post types will be deleted or modified. Posts, pages, some images, slider revolution, some widgets and menus will get imported.</li>
								<li>If you have done any custom changes in Customizer then take backup because demo Customizer settings will be replaced with current settings.</li>
								<li>It is advised to use this demo importer on a strong Wordpress installation.</li>
								<li>Please click import only once and wait, it can take a couple of minutes.</li>
							</ul>

							<ul class="gyan-site-contents" style="display:none;">

								<li class="gyan-sites-import-plugins">
									<input type="checkbox" name="plugins" class="disabled checkbox" readonly checked="checked" />
									<strong><?php esc_html_e( 'Install Required Plugins', 'gyan-elements' ); ?></strong>
									<span class="gyan-sites-tooltip-icon" data-tip-id="gyan-sites-tooltip-plugins-settings"><span class="dashicons dashicons-editor-help"></span></span>
									<div class="gyan-sites-tooltip-message" id="gyan-sites-tooltip-plugins-settings" style="display: none;">
										<p><?php esc_html_e( 'Plugins needed to import this demo template are missing. Required (free) plugins will be installed and activated automatically.', 'gyan-elements' ); ?></p>
										<ul class="required-plugins-list"><span class="spinner is-active"></span></ul>
									</div>
								</li>

								<# if( 'gyan-sites' === data ) { #>
									<li class="gyan-sites-import-customizer">
										<label>
											<input type="checkbox" name="customizer" class="checkbox" checked="checked" />
											<strong><?php esc_html_e( 'Import Customizer Settings', 'gyan-elements' ); ?></strong>
											<span class="gyan-sites-tooltip-icon" data-tip-id="gyan-sites-tooltip-customizer-settings"><span class="dashicons dashicons-editor-help"></span></span>
											<div class="gyan-sites-tooltip-message" id="gyan-sites-tooltip-customizer-settings" style="display: none;">
											<p><?php esc_html_e( 'Selecting this option will reset all customizer settings and replace them with the imported ones. (Admin > Appearance > Customize) ', 'gyan-elements' ); ?></p>
											</div>
										</label>
									</li>
									<li class="gyan-sites-import-widgets">
										<label>
											<input type="checkbox" name="widgets" class="checkbox" checked="checked" />
											<strong><?php esc_html_e( 'Import Widgets', 'gyan-elements' ); ?></strong>
										</label>
									</li>
									<li class="gyan-sites-import-sliders">
										<label>
											<input type="checkbox" name="sliders" class="checkbox" checked="checked" />
											<strong><?php esc_html_e( 'Import Sliders', 'gyan-elements' ); ?></strong>
										</label>
									</li>
									<li class="gyan-sites-import-xml">
										<label>
											<input type="checkbox" name="xml" class="checkbox" checked="checked" />
											<strong><?php esc_html_e( 'Import Content', 'gyan-elements' ); ?></strong>
										</label>
										<span class="gyan-sites-tooltip-icon" data-tip-id="gyan-sites-tooltip-site-content"><span class="dashicons dashicons-editor-help"></span></span>
										<div class="gyan-sites-tooltip-message" id="gyan-sites-tooltip-site-content" style="display: none;"><p><?php esc_html_e( 'Selecting this option will import demo pages, posts, images, meta data, terms, menus, etc.', 'gyan-elements' ); ?></p></div>
									</li>
									<li class="gyan-sites-reset-data">
										<label>
											<input type="checkbox" name="reset" class="checkbox">
											<strong><?php esc_html_e( 'Delete Previously Imported Site', 'gyan-elements' ); ?></strong>
											<span class="gyan-sites-tooltip-icon" data-tip-id="gyan-sites-tooltip-reset-data"><span class="dashicons dashicons-editor-help"></span></span>
											<div class="gyan-sites-tooltip-message" id="gyan-sites-tooltip-reset-data" style="display: none;"><p><?php esc_html_e( 'WARNING: Selecting this option will delete all data from the previous demo import. Choose this option only if this is intended.', 'gyan-elements' ); ?></p><p><?php esc_html_e( 'You can find the backup to the current customizer settings at ', 'gyan-elements' ); ?><br/><code><?php esc_html_e( '/wp-content/uploads/gyan-elements/', 'gyan-elements' ); ?></code></p></div>
										</label>
									</li>
								<# } #>
							</ul>
						</div>
					</div>
				</div>
				<div class="gyn-importing-wrap">
					<#
					if( 'gyan-sites' === data ) {
						var string = 'sites';
					} else {
						var string = 'template';
					}
					#>
					<p>
					<?php
					/* translators: %s is the dynamic string. */
					printf( esc_html__( '
						Please be patient. The import procedure can take up to few minutes, based on your server\'s perfomance.', 'gyan-elements' ), '{{string}}' );
					?>
					</p>
					<p>
					<?php
					/* translators: %s is the dynamic string. */
					printf( esc_html__( 'Do not close the browser or nagivate away from this page until the %s is imported completely.', 'gyan-elements' ), '{{string}}' );
					?>
					</p>

					<div class="current-importing-status-wrap">
						<div class="current-importing-status">
							<div class="current-importing-status-title"></div>
							<div class="current-importing-status-description"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="gyn-btn-actions-wrap">
				<a href="#" class="button button-hero button-primary gyan-demo-import disabled site-install-site-button"><?php esc_html_e( 'Import', 'gyan-elements' ); ?></a>
				<a href="#" class="button button-hero button-primary gyan-sites-skip-and-import" style="display: none;"><?php esc_html_e( 'Skip & Import', 'gyan-elements' ); ?></a>
				<div class="button button-hero site-import-cancel"><?php esc_html_e( 'Cancel', 'gyan-elements' ); ?></div>
			</div>
		</div>
	</div>
</script>

<?php
wp_print_admin_notice_templates();